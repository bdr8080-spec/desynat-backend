@include('dealer.layout.header')

<section class="section dashboard">

<div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
    <div class="title24">Live Join Requests</div>
</div>

<!-- Agora SDK -->
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

<style>
.video-box {
    width: 600px;
    height: 450px;
    background: black;
    border-radius: 8px;
    overflow: hidden;
}

#video-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    align-items: center;
}
</style>

<h2>🎥 Auto Live Streaming</h2>

<!-- Channel -->
<input type="hidden" id="channel" value="{{ request()->channel_id }}">

<!-- Controls -->
<button onclick="leaveStream()">🚪 Leave</button>
<button onclick="toggleMute()" id="mute-btn">🎤 Mute</button>

<h3>👥 Live Users: <span id="user-count">0</span></h3>

<!-- Video Container -->
<div id="video-container"></div>

<script>
let client;
let localTracks = [];
let users = {};
let localUid = {{$liveRequest->uid ?? 0}};

let micTrack = null;
let micMuted = false;

// 🚀 AUTO START
window.addEventListener("load", async () => {

    const channel = document.getElementById('channel').value;

    if (!channel) {
        alert("Channel missing");
        return;
    }

    try {

        console.log("🚀 Starting LIVE...");

        // GET TOKEN
        const res = await fetch('/agora/token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ channel })
        });

        const data = await res.json();

        const appId = data.appId;
        const token = data.token;
        const uid = data.uid;

        // CREATE CLIENT
        client = AgoraRTC.createClient({
            mode: "live",
            codec: "vp8"
        });

        registerEvents();

        await client.setClientRole("host");

        // JOIN CHANNEL
        localUid = await client.join(appId, channel, token, uid);

        console.log("✅ Joined:", localUid);

        // 🎤 CREATE MIC + CAMERA
        const [mic, cam] = await AgoraRTC.createMicrophoneAndCameraTracks();

        micTrack = mic;
        localTracks = [mic, cam];

        // PUBLISH
        await client.publish(localTracks);

        console.log("🎥 LIVE STARTED");

        // LOCAL VIDEO
        const player = document.createElement("div");
        player.id = "user-" + localUid;
        player.className = "video-box";

        document.getElementById("video-container").appendChild(player);

        cam.play(player.id);

        updateUserCount();

    } catch (err) {
        console.error("❌ ERROR:", err);
        alert("Camera/Mic issue or token error");
    }
});


// 🎧 EVENTS
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

        if (mediaType === "video" && user.videoTrack) {

            const player = document.createElement("div");
            player.id = "user-" + user.uid;
            player.className = "video-box";

            document.getElementById("video-container").appendChild(player);

            user.videoTrack.play(player.id);
        }

        if (mediaType === "audio" && user.audioTrack) {
            user.audioTrack.play();
        }

        users[user.uid] = user;
        updateUserCount();
    });
}


// 👥 USER COUNT
function updateUserCount() {
    const count = Object.keys(users).length + 1;
    document.getElementById("user-count").innerText = count;
}


// 🎤 MUTE / UNMUTE
function toggleMute() {

    if (!micTrack) return;

    micMuted = !micMuted;

    if (micMuted) {
        micTrack.setEnabled(false);
        document.getElementById("mute-btn").innerText = "🔇 Unmute";
    } else {
        micTrack.setEnabled(true);
        document.getElementById("mute-btn").innerText = "🎤 Mute";
    }
}


// 🚪 LEAVE STREAM
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
        console.error(err);
    }
}
</script>

</section>

@include('dealer.layout.custom_code')
@include('dealer.layout.footer')