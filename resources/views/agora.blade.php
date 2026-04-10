<!DOCTYPE html>
<html>

<head>
    <title>Agora Live Streaming - Multi User</title>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

    <style>
    #video-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .video-box {
        width: 300px;
        height: 220px;
        background: black;
    }
    </style>
</head>

<body>

    <h2>🎥 Agora Live Streaming</h2>

    <input type="text" id="channel" placeholder="Enter Channel Name" />
    <button onclick="startStream()">Start</button>
    <button onclick="leaveStream()">Leave</button>

    <h3>👥 Live Users: <span id="user-count">0</span></h3>

    <div id="video-container"></div>

    <script>
    let client;
    let localTracks = [];
    let users = {};
    let localUid = null;

    async function startStream() {

        const channel = document.getElementById('channel').value;

        if (!channel) {
            alert("Channel name required");
            return;
        }

        console.log("🚀 Starting stream...");

        // 🔹 STEP 1: Get Token from Laravel
        let appId, token, uid;

        try {
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

            appId = data.appId;
            token = data.token;
            uid = data.uid;

            if (!appId) throw new Error("Missing App ID");

            console.log("✅ Token received");

        } catch (err) {
            console.error(err);
            alert("Token error");
            return;
        }

        // 🔹 STEP 2: Create Client
        client = AgoraRTC.createClient({
            mode: "live",
            codec: "vp8"
        });

        // 🔹 STEP 3: Events

        client.on("user-joined", (user) => {
            console.log("👤 Joined:", user.uid);
            users[user.uid] = user;
            updateUserCount();
        });

        client.on("user-left", (user) => {
            console.log("🚪 Left:", user.uid);

            delete users[user.uid];

            const player = document.getElementById("user-" + user.uid);
            if (player) player.remove();

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

        // 🔹 STEP 4: Role
        await client.setClientRole("host");

        // 🔹 STEP 5: Join
        localUid = await client.join(appId, channel, token, uid);

        console.log("✅ Joined:", localUid);

        // 🔹 STEP 6: Create Tracks
        localTracks = await AgoraRTC.createMicrophoneAndCameraTracks();

        // 🔹 STEP 7: Publish
        await client.publish(localTracks);

        // 🔹 STEP 8: Show Local Video
        const localPlayer = document.createElement("div");
        localPlayer.id = "user-" + localUid;
        localPlayer.className = "video-box";

        document.getElementById("video-container").appendChild(localPlayer);

        localTracks[1].play(localPlayer.id);

        updateUserCount();
    }

    function updateUserCount() {
        const count = Object.keys(users).length + 1; // include self
        document.getElementById("user-count").innerText = count;
    }

    // 🔴 Leave
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

            console.log("🚪 Left");

        } catch (err) {
            console.error(err);
        }
    }
    </script>

</body>

</html>