const API_URL = 'https://apistaging.dashfx.net';
document.addEventListener('DOMContentLoaded', function(){
    function registerServiceWorker() {
        // register the service worker (it will work even when the tab is closed)
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            navigator.serviceWorker.register('/webpush-service-worker.js')
                .then(function(swReg)  {
                    console.log('Service Worker is registered');
                    subscribeUserViaServiceWorker();
                })
                .catch(function(error) {
                    console.error('Service Worker registration failed', error);
                });
        }
    }

    function subscribeUserViaServiceWorker() {
        // subscribe the user (get user's push service endpoint and keys to push notifications to)
        navigator.serviceWorker.ready.then(function(swReg) {
            swReg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: 'BImBs_MiNxAVPZsGA2FXnDBMxj3a6m7z6UoHEZZ9SRUZ3a3wq57Z8zkcd-EwFsvCojGvLElF9N1cBqHU1YF7M00',
            })
                .then(function(result) {
                    const subscription = result.toJSON();
                    console.log('User is subscribed.');

                    // Send the subscription object to your server to store it
                    sendSubscriptionToServer(subscription);
                })
                .catch(function(error) {
                    console.error('Failed to subscribe the user:', error);
                });
        });
    }

    function sendSubscriptionToServer(subscription) {
        console.log('Prepare to send subscription data to the server.');

        // try to get the DashFX click id from the url
        const params = new URL(location.href).searchParams;
        const clickId = params.get('cid');
        const endpointURL = API_URL.concat("/api/webpush/subscription");
        const pageUrl = window.location.href;
        const userLang = navigator.languages;

        const data = {
            clickId: clickId,
            endpoint: subscription.endpoint,
            keyAuth: subscription.keys.auth,
            keyP256dh: subscription.keys.p256dh,
            pageUrl: pageUrl,
            userLanguage: userLang,
        }

        fetch(endpointURL, {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        }).then(res => {
            if (200 === res.status) {
                console.log("Subscription sent successfully!");
            } else {
                console.log("Error when sending subscription.");
            }
        });
    }

    // NOTIFICATION POPUP BEGIN **
    toggleNotificationPopup();
    function toggleNotificationPopup() {
        let notificationPermission = Notification.permission;
        let isPermissionDenied = 'denied' === notificationPermission;
        let isPermissionGranted = 'granted' === notificationPermission;
        if ('true' !== getStorageNotificationDismissed() && !isPermissionDenied && !isPermissionGranted) {
            appendNotificationPopup();
            showNotificationPopup();
        }
    }

    function dismissNotification() {
        setStorageNotificationDismissed();
        hideNotificationPopup();
    }

    function requestNotificationPermission() {
        // request permission from the user to send notifications
        Notification.requestPermission().then(function(permission) {
            if (permission === 'granted') {
                registerServiceWorker();
                hideNotificationPopup();
            } else {
                hideNotificationPopup();
                console.log('Notification permission denied.');
            }
        });
    }

    function showNotificationPopup() {
        document.getElementById('notificationPopup').style.display = 'block';
    }
    function hideNotificationPopup() {
        document.getElementById('notificationPopup').style.display = 'none';
    }

    function setStorageNotificationDismissed()
    {
        localStorage.setItem("notificationDismissed", 'true');
    }
    function resetStorageNotificationDismissed()
    {
        localStorage.removeItem("notificationDismissed");
    }
    function getStorageNotificationDismissed()
    {
        return localStorage.getItem("notificationDismissed");
    }
    function isNotificationDismissed()
    {
        return 'true' === getStorageNotificationDismissed();
    }

    function appendNotificationPopup() {
        document.body.innerHTML += `
        <div id="notificationPopup" class="nt-block"
             style="display: none;position: fixed; background: white; box-shadow: rgb(110 169 223 / 20%) 3px 1px 16px 0, rgb(239 239 239 / 30%) -6px -2px 8px 0; padding: 20px 30px; top: 15px; width: 400px; left: 50%; transform: translate(-50%, 0);border-radius: 10px">
            <div class="nt-wrapper">
                <div style="display: flex; flex-direction: row">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="50px" viewBox="0 0 100 100" version="1.1">
                            <g id="surface1">
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(25.490198%,58.039218%,99.607843%);fill-opacity:1;" d="M 58.535156 2.59375 C 61.324219 4.871094 63.648438 8.046875 64.0625 11.71875 C 64.125 13.28125 64.097656 14.84375 64.0625 16.40625 C 64.214844 16.464844 64.363281 16.523438 64.519531 16.582031 C 66.28125 17.3125 67.773438 18.820312 69.140625 20.117188 C 69.417969 20.371094 69.417969 20.371094 69.703125 20.632812 C 73.414062 24.125 75.78125 28.675781 77.195312 33.519531 C 77.246094 33.683594 77.292969 33.847656 77.34375 34.015625 C 78.074219 36.613281 78.195312 39.175781 78.234375 41.859375 C 78.242188 46.300781 78.242188 46.300781 78.84375 50.683594 C 78.878906 50.835938 78.914062 50.992188 78.949219 51.152344 C 80.488281 57.828125 84.570312 63.101562 90.296875 66.734375 C 90.460938 66.839844 90.625 66.941406 90.796875 67.046875 C 92.210938 67.929688 93.402344 68.882812 94.1875 70.386719 C 94.277344 70.550781 94.367188 70.71875 94.460938 70.890625 C 95.105469 72.332031 95.417969 73.585938 95.398438 75.171875 C 95.394531 75.429688 95.394531 75.429688 95.394531 75.691406 C 95.359375 77.019531 95.15625 78.113281 94.53125 79.296875 C 94.449219 79.460938 94.371094 79.628906 94.285156 79.796875 C 93.078125 82.046875 91.214844 83.289062 88.867188 84.179688 C 88.296875 84.347656 87.792969 84.398438 87.199219 84.398438 C 86.933594 84.398438 86.933594 84.398438 86.664062 84.398438 C 86.46875 84.398438 86.277344 84.398438 86.078125 84.398438 C 85.875 84.398438 85.671875 84.398438 85.460938 84.398438 C 84.785156 84.398438 84.113281 84.394531 83.4375 84.394531 C 82.96875 84.394531 82.503906 84.394531 82.035156 84.394531 C 80.804688 84.390625 79.574219 84.390625 78.34375 84.386719 C 77.089844 84.386719 75.832031 84.386719 74.578125 84.382812 C 72.113281 84.382812 69.652344 84.378906 67.1875 84.375 C 67.175781 84.519531 67.164062 84.667969 67.152344 84.816406 C 67.132812 85.007812 67.117188 85.203125 67.101562 85.398438 C 67.085938 85.589844 67.070312 85.78125 67.050781 85.976562 C 66.609375 90.011719 64.058594 93.757812 61.019531 96.320312 C 56.773438 99.53125 52.183594 100.507812 46.957031 99.945312 C 44.796875 99.625 42.898438 98.734375 41.015625 97.65625 C 40.847656 97.5625 40.683594 97.46875 40.511719 97.371094 C 36.769531 95.046875 34.417969 91.320312 33.144531 87.179688 C 33.019531 86.582031 32.953125 86.015625 32.902344 85.410156 C 32.886719 85.214844 32.867188 85.019531 32.851562 84.820312 C 32.839844 84.675781 32.824219 84.527344 32.8125 84.375 C 32.554688 84.375 32.296875 84.378906 32.035156 84.378906 C 29.605469 84.394531 27.175781 84.40625 24.75 84.414062 C 23.5 84.417969 22.253906 84.425781 21.003906 84.433594 C 19.800781 84.441406 18.59375 84.445312 17.386719 84.449219 C 16.929688 84.449219 16.46875 84.453125 16.011719 84.457031 C 15.367188 84.464844 14.722656 84.464844 14.078125 84.464844 C 13.890625 84.464844 13.699219 84.46875 13.507812 84.472656 C 11.21875 84.457031 9.046875 83.523438 7.339844 82 C 5.433594 80.03125 4.578125 77.726562 4.492188 75 C 4.636719 72.363281 5.664062 70.003906 7.59375 68.175781 C 8.5 67.402344 9.496094 66.8125 10.515625 66.195312 C 11.882812 65.355469 13.070312 64.359375 14.257812 63.28125 C 14.449219 63.113281 14.449219 63.113281 14.644531 62.945312 C 18.082031 59.765625 20.261719 55.035156 21.179688 50.511719 C 21.207031 50.367188 21.238281 50.222656 21.269531 50.070312 C 21.648438 47.976562 21.6875 45.839844 21.714844 43.71875 C 21.714844 43.542969 21.71875 43.367188 21.722656 43.1875 C 21.730469 42.46875 21.738281 41.746094 21.742188 41.027344 C 21.773438 35.910156 22.929688 31.246094 25.390625 26.757812 C 25.488281 26.578125 25.585938 26.398438 25.6875 26.210938 C 27.726562 22.667969 31.355469 18.066406 35.304688 16.597656 C 35.777344 16.257812 35.777344 16.257812 35.824219 15.792969 C 35.855469 15.230469 35.855469 14.671875 35.851562 14.109375 C 35.925781 10.183594 37.085938 6.839844 39.886719 4.03125 C 44.890625 -0.742188 52.851562 -1.699219 58.535156 2.59375 Z M 58.535156 2.59375 "/>
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(21.176471%,41.960785%,98.431373%);fill-opacity:1;" d="M 32.8125 84.375 C 44.15625 84.375 55.5 84.375 67.1875 84.375 C 66.75 89.179688 64.726562 93.195312 61.019531 96.320312 C 56.773438 99.53125 52.183594 100.507812 46.957031 99.945312 C 44.796875 99.625 42.898438 98.734375 41.015625 97.65625 C 40.847656 97.5625 40.683594 97.46875 40.511719 97.371094 C 36.769531 95.046875 34.417969 91.320312 33.144531 87.179688 C 32.953125 86.257812 32.898438 85.3125 32.8125 84.375 Z M 32.8125 84.375 "/>
                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(21.568628%,42.352942%,98.431373%);fill-opacity:1;" d="M 58.535156 2.59375 C 61.328125 4.875 63.640625 8.046875 64.0625 11.71875 C 64.121094 13.214844 64.101562 14.714844 64.0625 16.210938 C 63.242188 16.066406 62.65625 15.808594 61.925781 15.40625 C 59.421875 14.09375 56.519531 13.191406 53.710938 12.890625 C 53.566406 12.871094 53.421875 12.847656 53.273438 12.828125 C 50.523438 12.464844 47.640625 12.585938 44.921875 13.085938 C 44.542969 13.152344 44.542969 13.152344 44.15625 13.222656 C 41.445312 13.761719 38.683594 14.761719 36.328125 16.210938 C 36.199219 16.210938 36.070312 16.210938 35.9375 16.210938 C 35.789062 11.828125 36.269531 7.957031 39.332031 4.601562 C 44.324219 -0.601562 52.566406 -1.914062 58.535156 2.59375 Z M 58.535156 2.59375 "/>
                            </g>
                        </svg>
                    </div>
                    <div style="font-family: system-ui;font-size: 15px;padding: 0 10px;line-height: 20px!important;">We'd like to show you
                        notifications for the latest news and updates.
                    </div>
                </div>
                <div class="nt-buttons" style="display: flex;flex-direction: row;justify-content: right;">
                    <button id="btnNotifDismiss"
                            style="border: none;background: none;color: #1b81d5;font-size: 14px; cursor: pointer;font-weight: normal!important;text-align: center;width: 80px;height: 34px;padding: 0 !important; box-shadow: none !important;">No
                        Thanks
                    </button>
                    <button id="btnNotifAllow"
                            style="border: none;border-radius: 4px;background: #1b81d5;padding: 0!important;color: white;margin-left: 10px;cursor: pointer;font-weight: normal!important;text-align: center;width: 80px;height: 34px;box-shadow: none !important;">Allow
                    </button>
                </div>
            </div>
        </div>
        `

        document.getElementById("btnNotifDismiss").addEventListener("click", dismissNotification);
        document.getElementById("btnNotifAllow").addEventListener("click", requestNotificationPermission);
    }
    // NOTIFICATION POPUP END **
});
