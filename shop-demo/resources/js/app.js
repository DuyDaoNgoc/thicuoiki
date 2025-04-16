import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
import Pusher from "pusher-js";

Pusher.logToConsole = true;

// Khởi tạo Pusher với App Key và Cluster
var pusher = new Pusher("your_pusher_app_key", {
    cluster: "your_pusher_app_cluster",
    forceTLS: true,
});

// Subscribe vào channel và lắng nghe sự kiện
var channel = pusher.subscribe("my-channel");
channel.bind("my-event", function (data) {
    alert("New message: " + data.message);
});
