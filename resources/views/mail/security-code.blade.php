<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code</title>
</head>
<body style="background-color: darkgray">
<div style="width: 100vw;display: flex; justify-content: center; padding-top: 50px">
    <div style="width: 400px; height: 300px; display: flex; flex-direction: column; justify-content: center;align-items: center;border: 2px solid dimgray;background-color: white; border-radius: 1rem;">
        <svg id="Layer_1" enable-background="new 0 0 510 510" height="100" viewBox="0 0 510 510" width="100"
             xmlns="http://www.w3.org/2000/svg">
            <g id="XMLID_130_">
                <g id="XMLID_516_">
                    <path id="XMLID_530_"
                          d="m0 255c0 140.932 114.049 255 255 255l15-255-15-255c-140.932 0-255 114.05-255 255z"
                          fill="#fdbf13"/>
                    <path id="XMLID_527_" d="m255 0v510c140.932 0 255-114.049 255-255 0-140.931-114.049-255-255-255z"
                          fill="#ff9313"/>
                    <path id="XMLID_524_"
                          d="m30 255c0 124.065 100.935 225 225 225l15-225-15-225c-124.065 0-225 100.935-225 225z"
                          fill="#ffda40"/>
                    <path id="XMLID_517_" d="m255 30v450c124.065 0 225-100.935 225-225s-100.935-225-225-225z"
                          fill="#fdbf13"/>
                </g>
                <path id="XMLID_491_"
                      d="m240 60v30.762c-37.122 3.359-73.316 19.21-101.673 47.565-64.333 64.333-64.333 169.011 0 233.345 28.36 28.36 64.548 44.207 101.673 47.565v30.763h15l10-195-10-195zm0 329.1c-29.414-3.261-57.954-16.135-80.459-38.64-52.637-52.637-52.637-138.283 0-190.919 22.505-22.505 51.045-35.379 80.459-38.64z"
                      fill="#ff9313"/>
                <path id="XMLID_494_"
                      d="m270 389.1v-268.199c29.414 3.26 57.954 16.134 80.46 38.64l21.213-21.213c-28.357-28.356-64.551-44.206-101.673-47.566v-30.762h-15v390h15v-30.762c37.12-3.36 73.32-19.212 101.673-47.565l-21.213-21.213c-22.505 22.506-51.046 35.38-80.46 38.64z"
                      fill="#ff592e"/>
            </g>
        </svg>
        <div style="margin-top:50px;font-size: 1.1rem; font-weight: bolder">Security code:</div>
        <div style="font-size: 3rem; font-weight: bold;letter-spacing: 4px">
            {{$code}}
        </div>
    </div>
</div>
</body>
</html>