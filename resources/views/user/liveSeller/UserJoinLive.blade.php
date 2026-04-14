@extends('user.layout.app')

@section('content')

<style>
#video-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    align-items: center;
}
</style>

<section class="section dashboard">

<h2>👀 Watch Live</h2>

<input type="hidden" id="channel" value="{{ request()->channel_id }}">

<button onclick="leaveStream()">🚪 Leave</button>

<h3 style="display: none;">
    👥 Watching: <span id="user-count">0</span>
</h3>

<!-- WAITING -->
<div id="waiting-message" style="text-align:center; padding:40px;">
    <h3>⏳ Waiting for seller to go LIVE</h3>
    <p>Please stay tuned...</p>
</div>

<!-- VIDEO -->
<div id="video-container"></div>

<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

<script>
let client;
let users = {};

AgoraRTC.setLogLevel(2);

window.addEventListener("load", async () => {

    const channel = document.getElementById('channel').value;

    if (!channel) {
        alert("Channel missing");
        return;
    }

    try {

        console.log("👀 Joining as audience...");

        // TOKEN
        const res = await fetch('/agora/token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ channel })
        });

        const data = await res.json();

        // CLIENT
        client = AgoraRTC.createClient({
            mode: "live",
            codec: "vp8"
        });

        registerEvents();

        // AUDIENCE ROLE
        await client.setClientRole("audience");

        // JOIN
        await client.join(data.appId, channel, data.token, data.uid);

        // 🔥 ENABLE AUDIO (IMPORTANT FIX)
        client.enableAudio();

        console.log("✅ Joined as audience");

    } catch (err) {
        console.error("❌ Error:", err);
    }
});


// 🎧 EVENTS
function registerEvents() {

    client.on("user-published", async (user, mediaType) => {

        document.getElementById("waiting-message")?.remove();

        await client.subscribe(user, mediaType);

        // 🎥 VIDEO
        if (mediaType === "video" && user.videoTrack) {

            const player = document.createElement("div");
            player.id = "user-" + user.uid;
            player.style.width = "600px";
            player.style.height = "350px";
            player.style.background = "black";
            player.style.borderRadius = "8px";

            document.getElementById("video-container").appendChild(player);

            user.videoTrack.play(player.id);
        }

        // 🔊 AUDIO FIXED
        if (mediaType === "audio" && user.audioTrack) {

            try {
                user.audioTrack.play();
            } catch (err) {
                console.warn("Autoplay blocked, retrying on click");

                document.body.addEventListener("click", () => {
                    user.audioTrack.play();
                }, { once: true });
            }
        }

        users[user.uid] = user;
        updateUserCount();
    });

    // 🔴 HOST LEFT
    client.on("user-left", (user) => {

        delete users[user.uid];

        document.getElementById("user-" + user.uid)?.remove();

        updateUserCount();

        if (Object.keys(users).length === 0) {
            showWaitingMessage();
        }
    });
}


// 👥 USER COUNT
function updateUserCount() {
    document.getElementById("user-count").innerText = Object.keys(users).length;
}


// ⏳ WAITING MESSAGE
function showWaitingMessage() {

    if (!document.getElementById("waiting-message")) {

        const div = document.createElement("div");
        div.id = "waiting-message";
        div.style.textAlign = "center";
        div.style.padding = "40px";

        div.innerHTML = `
            <h3>⏳ Waiting for seller to go LIVE</h3>
            <p>Please stay tuned...</p>
        `;

        document.querySelector('.dashboard').prepend(div);
    }
}


// 🚪 LEAVE STREAM
async function leaveStream() {

    try {

        await client.leave();

        document.getElementById("video-container").innerHTML = "";
        document.getElementById("user-count").innerText = 0;

        showWaitingMessage();

        users = {};

        console.log("🚪 Left stream");

        window.location.href='/user/get-live-seller-records';

    } catch (err) {
        console.error("❌ Leave Error:", err);
    }
}
</script>

</section>

@endsection