<!DOCTYPE html>
<html>

<head>
    <title>Agora Live Streaming (Host + Audience)</title>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
</head>

<body>

    <h2>Agora Live Streaming</h2>

    <input type="text" id="channel" placeholder="Enter Channel Name" />

    <select id="role">
        <option value="host">Host (Streamer)</option>
        <option value="audience">Audience (Viewer)</option>
    </select>

    <button onclick="startStream()">Start</button>
    <button onclick="leaveStream()">Leave</button>

    <br><br>

    <div id="local-player" style="width:400px;height:300px;background:#000;"></div>
    <div id="remote-player" style="width:400px;height:300px;background:#000;"></div>

    <script>
    let client;
    let localTracks = [];

    async function startStream() {

        const channel = document.getElementById('channel').value;
        const role = document.getElementById('role').value;

        if (!channel) {
            alert("Channel name required");
            return;
        }

        console.log("🚀 Starting as:", role);

        let appId, token, uid;

        // 🔹 STEP 1: Fetch Token
        try {
            const response = await fetch('/agora/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    channel,
                    role
                })
            });

            const data = await response.json();

            console.log("TOKEN:", data);

            appId = data.appId;
            token = data.token;
            uid = data.uid;

        } catch (err) {
            console.error("❌ Token Error:", err);
            return;
        }

        // 🔹 STEP 2: Create Client
        client = AgoraRTC.createClient({
            mode: "live",
            codec: "vp8"
        });

        AgoraRTC.setLogLevel(0);

        // 🔹 STEP 3: Remote User Listener
        client.on("user-published", async (user, mediaType) => {
            console.log("📡 Remote user:", user.uid);

            await client.subscribe(user, mediaType);

            if (mediaType === "video") {
                user.videoTrack.play("remote-player");
            }

            if (mediaType === "audio") {
                user.audioTrack.play();
            }
        });

        // 🔹 STEP 4: Set Role
        if (role === "host") {
            await client.setClientRole("host");
        } else {
            await client.setClientRole("audience");
        }

        // 🔹 STEP 5: Join Channel
        try {
            const joinedUid = await client.join(appId, channel, token, uid);
            console.log("✅ Joined:", joinedUid);
        } catch (err) {
            console.error("❌ JOIN ERROR:", err);
            return;
        }

        // 🔥 ONLY HOST STREAMS
        if (role === "host") {
            try {
                localTracks = await AgoraRTC.createMicrophoneAndCameraTracks();

                await client.publish(localTracks);

                localTracks[1].play("local-player");

                console.log("🎥 Host streaming...");
            } catch (err) {
                console.error("❌ Host Error:", err);
            }
        }
    }

    // 🔴 Leave
    async function leaveStream() {
        try {
            for (let track of localTracks) {
                track.stop();
                track.close();
            }

            await client.leave();

            console.log("🚪 Left");

        } catch (err) {
            console.error("❌ Leave Error:", err);
        }
    }
    </script>

</body>

</html>