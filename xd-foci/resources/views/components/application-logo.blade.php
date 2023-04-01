<style>
.cls-1,
.cls-2,
.cls-3 {
  fill: none;
  stroke: #fff;
}

.cls-1 {
  stroke-miterlimit: 22.93;
  stroke-width: 2px;
}

.cls-2,
.cls-3 {
  stroke-linecap: round;
  stroke-linejoin: round;
}

.cls-2 {
  stroke-width: 1.5px;
}

.cls-3 {
  stroke-width: 2px;
}

.icon-wrapper #air {
  stroke-dashoffset: 66;
  stroke-dasharray: 33;
  transition: all 2s ease;
}

.icon-wrapper:hover #air {
  stroke-dashoffset: 0;
}

.icon-wrapper #ball {
  transition: all 1.5s ease;
  transform: rotate(0);
  transform-origin: center;
}

.icon-wrapper:hover #ball {
  transform: rotate(360deg);
}
</style>

<svg id="icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" {{$attributes}}>
    <title></title>
        <g id="ball">
            <path id="circle" class="cls-1" d="M46,82.36A29.44,29.44,0,1,0,16.58,52.93,29.44,29.44,0,0,0,46,82.36Z" />
            <g id="hexagons">
                <path class="cls-2" d="M43.63,33.41l-9,5.74,2.82,10.22,11,.12,3.75-9.93ZM64.52,60.15l-9.62.17L50,69.6l6,5.19,8.73-5.47Zm4.94-25-4.62-1-1.37,5.26,5.85,9.51,5.84-.13m-50-16.64-.14,7-5.14,9.17-3,.29M31.3,59.87,23.24,60l.88,8.13,8.79,6.24,4.2-4.81ZM38.75,24.4l5.85,2.1,8.75-1.93" />
                <path class="cls-2" d="M23.24,60,19.92,48.27M41.73,82.05h0l-8.81-7.69m23.1.44-5.73,7.26h0M68.91,71.44l-4.17-2.12m4.58-20.44-4.8,11.27m-9.62.17L48.44,49.49m-11-.12L31.3,59.87m3.32-20.72-9.56,0m38.41.27-11.28.19M44.6,26.5l-1,6.91M50,69.6l-12.93-.06" />
            </g>
        </g>
        <g id="air">
            <line class="cls-3" x1="65.86" y1="25.95" x2="83.42" y2="8.4" />
            <line class="cls-3" x1="70.42" y1="29.34" x2="82.74" y2="17.02" />
            <line class="cls-3" x1="73.68" y1="34.31" x2="79.13" y2="28.86" />
        </g>
</svg>
