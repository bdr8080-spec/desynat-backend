<!DOCTYPE html>
<html>

<head>
    <title>Agora Debug with Try-Catch</title>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
</head>

<body>

    <h2>Agora Streaming (Error Handling Enabled)</h2>

    <input type="text" id="channel" placeholder="Enter Channel Name" />
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

        if (!channel) {
            alert("Channel name required");
            return;
        }

        console.log("🚀 Starting stream...");

        // 🔹 STEP 1: Fetch Token
        let appId, token, uid;
        try {
            const response = await fetch('/agora/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    channel
                })
            });

            const data = await response.json();

            console.log("✅ Token API Response:", data);

            appId = data.appId;
            token = data.token;
            uid = data.uid;

            if (!appId) throw new Error("App ID missing");
            if (!token) console.warn("⚠️ Token is null (testing mode)");

        } catch (err) {
            console.error("❌ Token Fetch Error:", err);
            alert("Token API failed");
            return;
        }

        // 🔹 STEP 2: Create Client
        try {
            AgoraRTC.setLogLevel(0);

            client = AgoraRTC.createClient({
                mode: "live",
                codec: "vp8"
            });

            console.log("✅ Client created");

        } catch (err) {
            console.error("❌ Client Creation Error:", err);
            return;
        }

        // 🔹 STEP 3: Register Events
        try {
            client.on("user-published", async (user, mediaType) => {
                console.log("📡 Remote user published:", user.uid);

                await client.subscribe(user, mediaType);

                if (mediaType === "video") {
                    user.videoTrack.play("remote-player");
                }

                if (mediaType === "audio") {
                    user.audioTrack.play();
                }
            });

        } catch (err) {
            console.error("❌ Event Binding Error:", err);
        }

        // 🔹 STEP 4: Set Role
        try {
            await client.setClientRole("host");
            console.log("✅ Role set to HOST");
        } catch (err) {
            console.error("❌ Role Error:", err);
            return;
        }

        // 🔹 STEP 5: Join Channel
        try {
            // const joinedUid = await client.join(appId, channel, null, null);

            const joinedUid = await client.join(appId, channel, token, uid);

            console.log("✅ Joined channel with UID:", joinedUid);
        } catch (err) {
            console.error("❌ JOIN ERROR:", err);

            if (err.message.includes("invalid vendor key")) {
                alert("❌ Invalid App ID (Check .env)");
            }

            return;
        }

        // 🔹 STEP 6: Create Tracks
        try {
            localTracks = await AgoraRTC.createMicrophoneAndCameraTracks();
            console.log("✅ Tracks created");
        } catch (err) {
            console.error("❌ MIC/CAMERA ERROR:", err);
            alert("Camera/Microphone permission denied");
            return;
        }

        // 🔹 STEP 7: Publish
        try {
            await client.publish(localTracks);
            console.log("✅ Stream published");
        } catch (err) {
            console.error("❌ Publish Error:", err);
            return;
        }

        // 🔹 STEP 8: Play Local Video
        try {
            localTracks[1].play("local-player");
            console.log("🎥 Local video started");
        } catch (err) {
            console.error("❌ Video Play Error:", err);
        }
    }

    // 🔴 Leave Stream
    async function leaveStream() {
        try {
            for (let track of localTracks) {
                track.stop();
                track.close();
            }

            await client.leave();

            console.log("🚪 Left stream");

        } catch (err) {
            console.error("❌ Leave Error:", err);
        }
    }
    </script>

</body>

</html>