<!DOCTYPE html>
<html>

<head>
    <title>Agora Live</title>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
</head>

<body>

    <h2>Agora Live Video</h2>

    <button onclick="joinAsHost()">Join as Host</button>
    <button onclick="joinAsAudience()">Join as Audience</button>
    <button onclick="leaveCall()">Leave</button>

    <div id="local" style="width:400px;height:300px;background:#000"></div>
    <div id="remote"></div>

    <script>
    const APP_ID = "{{ env('AGORA_APP_ID') }}";

    const CHANNEL = "test";

    let client = AgoraRTC.createClient({
        mode: "live",
        codec: "vp8"
    });
    let localTracks = [];
    let uid = null;

    async function getToken() {
        const res = await fetch(`api/agora/tokenWeb?channel_name=${CHANNEL}`);
        return await res.json();
    }

    async function joinAsHost() {
        const data = await getToken();
        uid = data.uid;

        await client.setClientRole("host");
        await client.join(APP_ID, CHANNEL, data.token, uid);

        localTracks = await AgoraRTC.createMicrophoneAndCameraTracks();

        localTracks[1].play("local");
        await client.publish(localTracks);

        console.log("Host joined");
    }

    async function joinAsAudience() {
        const data = await getToken();
        uid = data.uid;

        await client.setClientRole("audience");
        await client.join(APP_ID, CHANNEL, data.token, uid);

        console.log("Audience joined");
    }

    client.on("user-published", async (user, mediaType) => {
        await client.subscribe(user, mediaType);

        if (mediaType === "video") {
            const div = document.createElement("div");
            div.id = user.uid;
            div.style.width = "400px";
            div.style.height = "300px";
            document.getElementById("remote").appendChild(div);

            user.videoTrack.play(div);
        }

        if (mediaType === "audio") {
            user.audioTrack.play();
        }
    });

    async function leaveCall() {
        localTracks.forEach(track => track.close());
        await client.leave();

        document.getElementById("local").innerHTML = "";
        document.getElementById("remote").innerHTML = "";

        console.log("Left call");
    }
    </script>

</body>

</html>