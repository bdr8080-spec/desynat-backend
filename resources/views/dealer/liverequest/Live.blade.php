@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Live Join Requests</div>
    </div>

    <!-- Agora SDK -->
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

    <style>

    .video-box {
        width:600px;
        height: 450px;
        background: black;
        border-radius: 8px;
        overflow: hidden;
    }

    #video-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;   /* ✅ horizontal center */
    align-items: center;       /* ✅ vertical align (if height available) */
}

    </style>

    <h2>🎥 Auto Live Streaming</h2>

    <!-- Channel -->
    <input type="hidden" id="channel" value="{{ request()->channel_id }}">

    <!-- Controls -->
    <button onclick="leaveStream()">🚪 Leave</button>

    <h3>👥 Live Users: <span id="user-count">0</span></h3>

    <!-- Video Container -->
    <div id="video-container"></div>

    <script>
    let client;
    let localTracks = [];
    let users = {};
    let localUid = {{$liveRequest->uid}};

    // ✅ AUTO GO LIVE ON PAGE LOAD
    window.addEventListener("load", async () => {

        const channel = document.getElementById('channel').value;

        if (!channel) {
            alert("Channel missing");
            return;
        }

        try {
            console.log("🚀 Auto starting LIVE...");

            // 🔹 FETCH TOKEN
            const res = await fetch('/agora/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    channel
                })
            });

            const data = await res.json();

            const appId = data.appId;
            const token = data.token;
            const uid = data.uid;

            if (!appId) throw new Error("Missing App ID");

            // 🔹 CREATE CLIENT
            client = AgoraRTC.createClient({
                mode: "live",
                codec: "vp8"
            });

            registerEvents();

            // 🔹 SET HOST ROLE
            await client.setClientRole("host");

            // 🔹 JOIN CHANNEL
            localUid = await client.join(appId, channel, token, uid);

            console.log("✅ Joined as HOST:", localUid);

            // 🔹 CREATE CAMERA + MIC
            localTracks = await AgoraRTC.createMicrophoneAndCameraTracks();

            // 🔹 PUBLISH STREAM
            await client.publish(localTracks);

            console.log("🎥 LIVE STARTED");

            // 🔹 SHOW LOCAL VIDEO
            const player = document.createElement("div");
            player.id = "user-" + localUid;
            player.className = "video-box";

            document.getElementById("video-container").appendChild(player);

            localTracks[1].play(player.id);

            updateUserCount();

        } catch (err) {
            console.error("❌ AUTO LIVE ERROR:", err);

            alert("Camera/Mic permission OR Token issue");

            // 👉 fallback (user interaction required)
            document.body.addEventListener("click", () => {
                location.reload();
            });
        }
    });

    // ✅ EVENTS
    function registerEvents() {

        client.on("user-joined", (user) => {
            users[user.uid] = user;
            updateUserCount();
        });

        client.on("user-left", (user) => {
            delete users[user.uid];

            const el = document.getElementById("user-" + user.uid);
            if (el) el.remove();

            updateUserCount();
        });

        client.on("user-published", async (user, mediaType) => {

            await client.subscribe(user, mediaType);

            if (mediaType === "video") {

                const player = document.createElement("div");
                player.id = "user-" + user.uid;
                player.className = "video-box";

                document.getElementById("video-container").appendChild(player);

                user.videoTrack.play(player.id);
            }

            if (mediaType === "audio") {
                user.audioTrack.play();
            }

            users[user.uid] = user;
            updateUserCount();
        });
    }

    // ✅ USER COUNT
    function updateUserCount() {
        const count = Object.keys(users).length + 1;
        document.getElementById("user-count").innerText = count;
    }

    // 🔴 LEAVE STREAM
    async function leaveStream() {
        try {

            for (let track of localTracks) {
                track.stop();
                track.close();
            }

            await client.leave();

            document.getElementById("video-container").innerHTML = "";
            document.getElementById("user-count").innerText = 0;

            users = {};

            console.log("🚪 Left stream");

        } catch (err) {
            console.error("❌ Leave Error:", err);
        }
    }
    </script>

</section>

@include('dealer.layout.custom_code')
@include('dealer.layout.footer')