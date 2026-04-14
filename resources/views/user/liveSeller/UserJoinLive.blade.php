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
.video-box {
    width: 600px;
    height: 350px;
    background: black;
    border-radius: 8px;
}
</style>

<section class="section dashboard">

<h2>👀 Watch Live</h2>

<input type="hidden" id="channel" value="{{ request()->channel_id }}">

<button onclick="leaveStream()">🚪 Leave</button>

<h3>👥 Watching: <span id="user-count">0</span></h3>

<!-- ⏳ WAITING -->
<div id="waiting-message" style="text-align:center; padding:40px;">
    <h3>⏳ Waiting for seller to go LIVE</h3>
    <p>Please stay tuned...</p>
</div>

<!-- 🎥 VIDEO -->
<div id="video-container"></div>

<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

<script>
let client;
let viewers = {};

window.addEventListener("load", async () => {

    const channel = document.getElementById('channel').value;

    if (!channel) {
        alert("Channel missing");
        return;
    }

    try {

        console.log("👀 Joining as audience...");

        // 🔹 TOKEN
        const res = await fetch('/agora/token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ channel })
        });

        const data = await res.json();

        // 🔥 RANDOM UID
        let uid = Math.floor(Math.random() * 1000000);

        // 🔹 CREATE CLIENT
        client = AgoraRTC.createClient({
            mode: "live",
            codec: "vp8"
        });

        registerEvents();

        // 👀 AUDIENCE ROLE
        await client.setClientRole("audience");

        // 🔹 JOIN CHANNEL
        await client.join(data.appId, channel, data.token, uid);

        console.log("✅ Joined as audience:", uid);

        // 🔊 unlock audio on user gesture
        document.body.addEventListener("click", () => {
            console.log("Audio unlocked");
        }, { once: true });

    } catch (err) {
        console.error("❌ Error:", err);
    }
});


// =======================
// 🎯 EVENTS
// =======================
function registerEvents() {

    // 🎥 HOST STREAM START
    client.on("user-published", async (user, mediaType) => {

        document.getElementById("waiting-message")?.remove();

        await client.subscribe(user, mediaType);

        viewers[user.uid] = true;

        if (mediaType === "video") {

            const player = document.createElement("div");
            player.id = "user-" + user.uid;
            player.className = "video-box";

            document.getElementById("video-container").appendChild(player);

            user.videoTrack.play(player.id);
        }

        if (mediaType === "audio") {
            user.audioTrack.setVolume(100);
            user.audioTrack.play();
        }

        updateUserCount();
    });

    // 🔴 HOST LEFT
    client.on("user-left", (user) => {

        delete viewers[user.uid];

        document.getElementById("user-" + user.uid)?.remove();

        updateUserCount();

        if (Object.keys(viewers).length === 0) {
            showWaitingMessage();
        }
    });
}


// =======================
// 👥 COUNT
// =======================
function updateUserCount() {
    document.getElementById("user-count").innerText = Object.keys(viewers).length;
}


// =======================
// ⏳ WAITING UI
// =======================
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


// =======================
// 🚪 LEAVE STREAM
// =======================
async function leaveStream() {

    try {

        await client.leave();

        document.getElementById("video-container").innerHTML = "";
        document.getElementById("user-count").innerText = 0;

        viewers = {};

        showWaitingMessage();

        console.log("🚪 Left stream");

    } catch (err) {
        console.error("❌ Leave Error:", err);
    }
}

</script>

</section>

@endsection