<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website</title>
    <!--    <link rel="stylesheet" href="./style.css">-->
    <!--    <link rel="icon" href="./favicon.ico" type="image/x-icon">-->
</head>
<body>
<main style="height: 1500px;">
    <h1>Welcome to My Website</h1>

    {{--    <div id="notificationPopup" class="nt-block" style="display: none;position: fixed; background: white; box-shadow: rgb(110 169 223 / 20%) 3px 1px 16px 0, rgb(239 239 239 / 30%) -6px -2px 8px 0; padding: 20px 30px; top: 15px; width: 360px; left: 50%; transform: translate(-50%, 0);border-radius: 10px">--}}
{{--        <div class="nt-wrapper">--}}
{{--            <div style="display: flex; flex-direction: row">--}}
{{--                <div><img src="{{ asset('images/notif-icon.png') }}" style="width: 50px"/></div>--}}
{{--                <div style="font-family: system-ui;font-size: 15px;padding: 0 10px">We'd like to show you notifications for the latest news and updates.</div>--}}
{{--            </div>--}}
{{--            <div class="nt-buttons" style="display: flex;flex-direction: row;justify-content: right;">--}}
{{--                <button id="btnNotifDismiss" style="border: none;background: none;color: #1b81d5;font-size: 14px; cursor: pointer;">No Thanks</button>--}}
{{--                <button id="btnNotifAllow" style="border: none;border-radius: 4px;background: #1b81d5;padding: 9px 24px;color: white;margin-left: 10px;cursor: pointer;">Allow</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</main>
{{--<script src="https://apistaging.dashfx.net/webpush-sdk.js"></script>--}}
<script src="{{asset('scripts/webpush-sdk.js')}}"></script>

</body>
</html>
