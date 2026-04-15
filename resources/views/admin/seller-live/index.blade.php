@extends('admin.layout.app')
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

<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">

        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="h2">Current Live Seller</h2>
                </div>

            </div>

            <div class="userManagecontent">
                <div class="mt-4">
                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Seller Name</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Watch Live</th>
                                    <th scope="col">Lived On</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($sellerLive as $key=>$val)

                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$val->seller_details->first_name}} {{$val->seller_details->last_name}}</td>
                                    <td>{{$val->timeslot_details->country_info->name}}</td>
                                    <!-- <td>
                                        <div data-bs-toggle="modal" data-bs-target="#videoshow"
                                            data-channel="{{$val->channel_id}}"><i class="bi bi-eye-fill"></i></div>
                                    </td> -->

                                    <td>
                                        <div data-bs-toggle="modal" data-bs-target="#videoshow"
                                            data-channel="{{$val->channel_id}}">
                                            <i class="bi bi-eye-fill" style="cursor:pointer;"></i>
                                        </div>


                                    <td>
                                        {{ \Carbon\Carbon::parse($val->timeslot_details->date)->format('d F Y') }}
                                        {{ \Carbon\Carbon::parse($val->timeslot_details->from)->format('g A') }}

                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="4">1</td>
                                </tr>
                                @endforelse

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Add Video Stream Modal -->

<div class="modal fade" id="videoshow" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">👀 Watch Live</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="channel">

                <!-- WAITING -->
                <div id="waiting-message" style="text-align:center; padding:40px;">
                    <h3>⏳ Waiting for seller to go LIVE</h3>
                    <p>Please stay tuned...</p>
                </div>

                <!-- VIDEO -->
                <div id="video-container"></div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" onclick="leaveStream()">🚪 Leave</button>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Agora SDK -->
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

<script>
let client;
let users = {};

const modal = document.getElementById('videoshow');

// ✅ OPEN MODAL → JOIN STREAM
modal.addEventListener('shown.bs.modal', async function(event) {

    const button = event.relatedTarget;
    const channel = button.getAttribute('data-channel');

    document.getElementById('channel').value = channel;

    if (!channel) {
        alert("Channel missing");
        return;
    }

    try {

        console.log("👀 Joining as audience...");

        // 🔥 TOKEN API (Laravel)
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

        // CLIENT
        client = AgoraRTC.createClient({
            mode: "live",
            codec: "vp8"
        });

        registerEvents();

        await client.setClientRole("audience");

        await client.join(data.appId, channel, data.token, data.uid);

        client.enableAudio();

        console.log("✅ Joined");

    } catch (err) {
        console.error("❌ Error:", err);
    }
});


// 🎧 EVENTS
function registerEvents() {

    client.on("user-published", async (user, mediaType) => {

        removeWaiting();

        await client.subscribe(user, mediaType);

        // 🎥 VIDEO
        if (mediaType === "video") {

            const player = document.createElement("div");
            player.id = "user-" + user.uid;
            player.style.width = "600px";
            player.style.height = "350px";
            player.style.background = "black";
            player.style.borderRadius = "8px";

            document.getElementById("video-container").appendChild(player);

            user.videoTrack.play(player.id);
        }

        // 🔊 AUDIO
        if (mediaType === "audio") {
            try {
                user.audioTrack.play();
            } catch {
                document.body.addEventListener("click", () => {
                    user.audioTrack.play();
                }, {
                    once: true
                });
            }
        }

        users[user.uid] = user;
    });

    // 🔴 USER LEFT
    client.on("user-left", (user) => {

        delete users[user.uid];

        document.getElementById("user-" + user.uid)?.remove();

        if (Object.keys(users).length === 0) {
            showWaiting();
        }
    });
}


// ⏳ SHOW WAITING
function showWaiting() {

    if (!document.getElementById("waiting-message")) {

        const div = document.createElement("div");
        div.id = "waiting-message";
        div.style.textAlign = "center";
        div.style.padding = "40px";

        div.innerHTML = `
            <h3>⏳ Waiting for seller to go LIVE</h3>
            <p>Please stay tuned...</p>
        `;

        document.querySelector('.modal-body').prepend(div);
    }
}


// ❌ REMOVE WAITING
function removeWaiting() {
    document.getElementById("waiting-message")?.remove();
}


// 🚪 LEAVE BUTTON
async function leaveStream() {

    try {

        if (client) {
            await client.leave();
        }

        document.getElementById("video-container").innerHTML = "";

        users = {};

        showWaiting();

        console.log("🚪 Left");

        // ✅ CLOSE MODAL PROPERLY
        // const modalEl = document.getElementById('videoshow');
        // const modalInstance = bootstrap.Modal.getInstance(modalEl);
        // modalInstance.hide();


    } catch (err) {
        console.error(err);
    }
}


// ❌ MODAL CLOSE
modal.addEventListener('hidden.bs.modal', async function() {

    if (client) {
        await client.leave();
    }

    document.getElementById("video-container").innerHTML = "";

    users = {};

    showWaiting();

    console.log("🚪 Closed");
});
</script>




</div>

@endsection