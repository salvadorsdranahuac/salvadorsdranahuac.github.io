function glslFloat(value) {
  return Number.isInteger(value) ? `${value}.` : `${value}`;
}

function createSNoise({
  zoom = 1.0,
  scaleX = 1.0,
  scaleY = 1.0,
  directionX = 0.0,
  directionY = -1.0,
  timeScale = 1,
}) {
  zoom *= 0.1;
  return `
        snoise(vec3(
            (st.x * 1. / (${glslFloat(scaleX)} * ${glslFloat(zoom)})) + (time * ${glslFloat(directionX)} * ${glslFloat(timeScale)}),
            (st.y * 1. / ( ${glslFloat(scaleY)} * ${glslFloat(zoom)})) + (time * ${glslFloat(directionY)} * ${glslFloat(timeScale)}),
            (time * ${glslFloat(timeScale)})
        )) 
    `;
}

function createBands({
  noiseVar = 'noise',
  count = 3,
  thickness = 1,
  feather = 1,
  min = -1.0,
  max = 1.0,
  output = 'bands'
}) {
  thickness *= 0.1;
  feather *= 0.1;

  let code = `float ${output} = 0.0;`;
  for (let i = 0; i < count; i++) {
    const t = count === 1 ? 0.5 : min + ((max - min) * (i / (count - 1)));
    code += `
      ${output} += smoothstep(
        ${glslFloat(thickness + feather)},
        ${glslFloat(thickness)},
        abs(${noiseVar} - ${glslFloat(t)})
      );
    `;
  }

  code += `${output} = clamp(${output}, 0.0, 1.0);`;
  return code;
}

let gradientMap = {
  0: '#d45800',
  50: '#9c340e',
  100: '#ffaa50'
}

function hexToRgb(hex) {
  hex = hex.replace('#', '');

  if (hex.length === 3) { hex = hex.split('').map(c => c + c).join(''); }

  return {
    r: (parseInt(hex.slice(0, 2), 16) / 255).toFixed(3),
    g: (parseInt(hex.slice(2, 4), 16) / 255).toFixed(3),
    b: (parseInt(hex.slice(4, 6), 16) / 255).toFixed(3),
  };
}

function glslFloat(value) {
  return Number.isInteger(value) ? `${value}.` : `${value}`;
}

let fragmentMain = `
    vec2 st = vUv;
    float y = st.y;
    float x = st.x;


    float noise1 =
      ${createSNoise({ zoom: 8, scaleX: 1, scaleY: 1, directionY: -3, timeScale: 0.02 })} * 0.7 +
      ${createSNoise({ zoom: 5, scaleX: 1, scaleY: 1, directionY: -3, timeScale: 0.02 })} * 0.3;

      
    noise1 = noise1 * 0.5 + 0.5;
     

    float shape = noise1;
    shape = pow(shape, 0.8);

    float s1 = smoothstep(0.35, 0.75, shape);
    float density = max(s1, pow(1.0 - vUv.y, 1.0));

    float layer1 = density; 
    layer1 = layer1;

    layer1 *= .7; 


    float noise2 = snoise(vec3(vUv.x * 3.0,vUv.y * 1.5,time * 0.2));

    noise2 = noise2 * 0.5 + 0.5;


    float warp =  ${createSNoise({ zoom: 6, scaleX: 0.4, directionX:0.5, scaleY: 1,timeScale: 0.2 })} * 0.5 + 0.5;
    float warpedY = vUv.y + (warp - 0.5) * 0.2;
    float lineY = pow(mod(time * 0.1, 1.2) , 2.5) -0.2;
    float n = ${createSNoise({ zoom: 6, scaleX: 0.12, scaleY: 3,timeScale: 0.2 })} * 0.5 + 0.5;
    float centerDist = smoothstep(0.0, 0.5, abs(vUv.x - 0.5) * 2.0); 
    float thickness = 0.01 * n * mix(0.3, 1.5, centerDist);
    float warpedLineY = lineY + (n - 0.5) * 0.08; // deform the line position
    float d = abs(warpedY - warpedLineY);
    float line = 1.0 - smoothstep( thickness, thickness + 0.01, d );

    float layer2 = line;
    layer2 *= 0.8;
    layer2 *= max(0.1,smoothstep(0.2, 0.9, vUv.y));
    float crt = sin(gl_FragCoord.x * 3.14159);
    layer2 *= 1.0 - crt;

    float final = layer1 ;//+ layer2;
    final *= 1.0 - crt*.5;
    

    gl_FragColor = vec4(gradientMap(final), 1.0);
`;

let Noise3D = `
vec3 mod289(vec3 x) {
  return x - floor(x * (1.0 / 289.0)) * 289.0;
}

vec4 mod289(vec4 x) {
  return x - floor(x * (1.0 / 289.0)) * 289.0;
}

vec4 permute(vec4 x) {
     return mod289(((x*34.0)+1.0)*x);
}

vec4 taylorInvSqrt(vec4 r)
{
  return 1.79284291400159 - 0.85373472095314 * r;
}

float snoise(vec3 v)
  { 
  const vec2  C = vec2(1.0/6.0, 1.0/3.0) ;
  const vec4  D = vec4(0.0, 0.5, 1.0, 2.0);

// First corner
  vec3 i  = floor(v + dot(v, C.yyy) );
  vec3 x0 =   v - i + dot(i, C.xxx) ;

// Other corners
  vec3 g = step(x0.yzx, x0.xyz);
  vec3 l = 1.0 - g;
  vec3 i1 = min( g.xyz, l.zxy );
  vec3 i2 = max( g.xyz, l.zxy );

  //   x0 = x0 - 0.0 + 0.0 * C.xxx;
  //   x1 = x0 - i1  + 1.0 * C.xxx;
  //   x2 = x0 - i2  + 2.0 * C.xxx;
  //   x3 = x0 - 1.0 + 3.0 * C.xxx;
  vec3 x1 = x0 - i1 + C.xxx;
  vec3 x2 = x0 - i2 + C.yyy; // 2.0*C.x = 1/3 = C.y
  vec3 x3 = x0 - D.yyy;      // -1.0+3.0*C.x = -0.5 = -D.y

// Permutations
  i = mod289(i); 
  vec4 p = permute( permute( permute( 
             i.z + vec4(0.0, i1.z, i2.z, 1.0 ))
           + i.y + vec4(0.0, i1.y, i2.y, 1.0 )) 
           + i.x + vec4(0.0, i1.x, i2.x, 1.0 ));

// Gradients: 7x7 points over a square, mapped onto an octahedron.
// The ring size 17*17 = 289 is close to a multiple of 49 (49*6 = 294)
  float n_ = 0.142857142857; // 1.0/7.0
  vec3  ns = n_ * D.wyz - D.xzx;

  vec4 j = p - 49.0 * floor(p * ns.z * ns.z);  //  mod(p,7*7)

  vec4 x_ = floor(j * ns.z);
  vec4 y_ = floor(j - 7.0 * x_ );    // mod(j,N)

  vec4 x = x_ *ns.x + ns.yyyy;
  vec4 y = y_ *ns.x + ns.yyyy;
  vec4 h = 1.0 - abs(x) - abs(y);

  vec4 b0 = vec4( x.xy, y.xy );
  vec4 b1 = vec4( x.zw, y.zw );

  //vec4 s0 = vec4(lessThan(b0,0.0))*2.0 - 1.0;
  //vec4 s1 = vec4(lessThan(b1,0.0))*2.0 - 1.0;
  vec4 s0 = floor(b0)*2.0 + 1.0;
  vec4 s1 = floor(b1)*2.0 + 1.0;
  vec4 sh = -step(h, vec4(0.0));

  vec4 a0 = b0.xzyw + s0.xzyw*sh.xxyy ;
  vec4 a1 = b1.xzyw + s1.xzyw*sh.zzww ;

  vec3 p0 = vec3(a0.xy,h.x);
  vec3 p1 = vec3(a0.zw,h.y);
  vec3 p2 = vec3(a1.xy,h.z);
  vec3 p3 = vec3(a1.zw,h.w);

//Normalise gradients
  vec4 norm = taylorInvSqrt(vec4(dot(p0,p0), dot(p1,p1), dot(p2, p2), dot(p3,p3)));
  p0 *= norm.x;
  p1 *= norm.y;
  p2 *= norm.z;
  p3 *= norm.w;

// Mix final noise value
  vec4 m = max(0.6 - vec4(dot(x0,x0), dot(x1,x1), dot(x2,x2), dot(x3,x3)), 0.0);
  m = m * m;
  return 42.0 * dot( m*m, vec4( dot(p0,x0), dot(p1,x1),dot(p2,x2), dot(p3,x3) ) );
  }
`

function createGradientMap(stops = {}) {
  const sortedStops = Object.entries(stops).map(([k, v]) => ({
    position: Number(k) / 100,
    color: hexToRgb(v)
  })).sort((a, b) => a.position - b.position);

  let glsl = `vec3 gradientMap(float t) { t = clamp(t, 0.0, 1.0);`;

  for (let i = 0; i < sortedStops.length - 1; i++) {
    const current = sortedStops[i];
    const next = sortedStops[i + 1];
    const start = glslFloat(current.position);
    const end = glslFloat(next.position);
    const range = glslFloat(next.position - current.position);
    const c1 = `vec3(${current.color.r}, ${current.color.g}, ${current.color.b})`;
    const c2 = `vec3(${next.color.r}, ${next.color.g}, ${next.color.b})`;
    const condition = i === 0 ? `if(t <= ${end})` : `else if(t <= ${end})`;
    glsl += `${condition} { return mix(${c1}, ${c2}, (t - ${start}) / ${range}); }`;
  }

  const last = sortedStops[sortedStops.length - 1];

  glsl += `return vec3(${last.color.r}, ${last.color.g}, ${last.color.b});}`;
  return glsl;
}


const shaders = {
  vertex: `
    varying vec2 vUv;

    void main() {
      vUv = uv;
      gl_Position = vec4(position, 1.0);
    }
  `,

  fragment: `
    varying vec2 vUv;
    uniform vec2 resolution;
    uniform float time;

    ${Noise3D}

    ${createGradientMap(gradientMap)}

    void main() {
      ${fragmentMain}
    }
  `
};

const container = document.querySelector('.opportunities');

let width = container.offsetWidth;
let height = container.offsetHeight;

const scene = new THREE.Scene();

const camera = new THREE.OrthographicCamera(
  -1, 1,
  1, -1,
  0, 1
);

const renderer = new THREE.WebGLRenderer({
  alpha: true,
  antialias: true
});

renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(width, height, false);

container.appendChild(renderer.domElement);

renderer.domElement.className =  "absolute inset-0 w-full h-full pointer-events-none opacity-[50%]";

/**
 * IMPORTANT:
 * container must be relative
 */
container.classList.add('relative');

const geometry = new THREE.PlaneGeometry(2, 2);

const uniforms = {
  time: { value: 0 },
  resolution: { value: new THREE.Vector2(width, height) }
};

const material = new THREE.ShaderMaterial({
  uniforms,
  vertexShader: shaders.vertex,
  fragmentShader: shaders.fragment,
  depthTest: false,
  depthWrite: false,
  transparent: true
});

const mesh = new THREE.Mesh(geometry, material);
scene.add(mesh);

function onResize() {
  width = container.offsetWidth;
  height = container.offsetHeight;

  renderer.setSize(width, height, false);

  uniforms.resolution.value.set(width, height);
}

window.addEventListener("resize", onResize);

const startTime = Date.now();

function render() {
  uniforms.time.value = (Date.now() - startTime) / 1000;

  renderer.render(scene, camera);

  requestAnimationFrame(render);
}

render();


/* ============================================================================
   HALFTONE DOT FIELDS  (added after the original perlin.js content)
   ----------------------------------------------------------------------------
   One shared GPU shader drives two canvases:
     #heroDots     - samples #heroVideo into a grid of noise-sized dots
     #sectionDots  - the SAME grid as a section background, no video, inverted
                     (the dots are the visible marks), with a noise-wavy top
                     edge that fades out slowly downward.
   Throttled to 30fps; each canvas pauses when off-screen / tab hidden.

   GEOMETRY / NOISE KNOBS are shared by both fields (see below). Only the
   COLORS differ between the hero and the section.
   ============================================================================ */
(function () {
    if (typeof THREE === 'undefined') return;

    // ===== hero geometry / noise (the video mask) ========================
    const HERO_DOTSIZE     = 3;      // dot radius in px (at GRIDSCALE = 1)
    const HERO_GAP         = 18;     // spacing between dots in px (at GRIDSCALE = 1)
    const HERO_GRIDSCALE   = 0.8;    // zooms the grid: scales dot + gap together
    const HERO_VARIATION   = 0.8;    // noise-driven size variation (0-1)
    const HERO_NOISE_SCALE = 0.2;    // noise feature size (smaller = bigger blobs)
    const HERO_SPEED       = 2.0;    // animation speed (1 = default, 0 = frozen)

    // ===== section geometry / noise (independent from the hero) ==========
    const SEC_DOTSIZE      = 2;      // dot radius in px (at GRIDSCALE = 1)
    const SEC_GAP          = 18;     // spacing between dots in px (at GRIDSCALE = 1)
    const SEC_GRIDSCALE    = 0.8;    // zooms the grid: scales dot + gap together
    const SEC_VARIATION    = 0.8;    // noise-driven size variation (0-1)
    const SEC_NOISE_SCALE  = 0.2;    // noise feature size (smaller = bigger blobs)
    const SEC_SPEED        = 2.0;    // animation speed (1 = default, 0 = frozen)

    const FPS = 30;

    // ===== hero colours (composited over the video) ======================
    const HERO_OPAQUE = 'rgb(32, 29, 33)';      // field between dots
    const HERO_HOLE   = 'rgba(0, 0, 0, 0.34)';  // inside dots

    // ===== section pattern (same grid, no video, dots are visible) =======
    const SECTION_DOT        = 'rgb(93, 43, 0)';  // dot colour
    const SECTION_FADE_START = 0.50;   // where the downward fade begins (0 = top)
    const SECTION_FADE_END   = 0.95;   // where it has fully faded (1 = bottom)
    const SECTION_FADE_WAVE  = 0.07;   // how much the bottom fade edge follows the noise
    // ---------------------------------------------------------------------

    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const geom = (dot, gap, grid, amp, scale, speed) =>
        ({ base: dot * grid, gap: gap * grid, amp: amp, scale: scale, speed: speed });

    const parseColor = (css) => {
        const cv = document.createElement('canvas'); cv.width = cv.height = 1;
        const c = cv.getContext('2d'); c.clearRect(0, 0, 1, 1);
        c.fillStyle = css; c.fillRect(0, 0, 1, 1);
        const d = c.getImageData(0, 0, 1, 1).data;
        return new THREE.Vector4(d[0] / 255, d[1] / 255, d[2] / 255, d[3] / 255);
    };

    const FRAG = `
        precision highp float;
        varying vec2 vUv;
        uniform sampler2D uTex;
        uniform vec2 uRes, uVid;
        uniform vec3 uFade;
        uniform vec4 uOpaque, uHole;
        uniform float uTime, uGap, uAmp, uBase, uScale, uUseVideo, uPattern;

        float noise(vec2 c, float t) {
            return (
                sin(c.x * 0.9 + t * 0.7) +
                sin(c.y * 0.8 - t * 0.6) +
                sin((c.x + c.y) * 0.5 + t * 0.9) +
                sin(length(c - vec2(4.0, 3.0)) * 0.7 - t * 1.1)
            ) * 0.25;
        }

        void main() {
            float ca = uRes.x / uRes.y;
            float va = uVid.x / uVid.y;
            vec2 uvc = vUv;
            if (ca > va) uvc.y = (vUv.y - 0.5) * (va / ca) + 0.5;
            else         uvc.x = (vUv.x - 0.5) * (ca / va) + 0.5;
            vec3 vid = uUseVideo > 0.5 ? texture2D(uTex, uvc).rgb : vec3(1.0);

            vec2 px = vUv * uRes;
            vec2 cell = floor(px / uGap);
            vec2 center = (cell + 0.5) * uGap;
            float d = distance(px, center);
            float nz = noise(cell * uScale, uTime);
            float r = uBase * (1.0 + uAmp * nz);
            float mask = 1.0 - smoothstep(r - 0.75, r + 0.75, d);

            if (uPattern < 0.5) {
                vec4 hole  = vec4(vid * mix(vec3(1.0), uHole.rgb,   uHole.a),   1.0);
                vec4 field = vec4(vid * mix(vec3(1.0), uOpaque.rgb, uOpaque.a), 1.0);
                gl_FragColor = mix(field, hole, mask);
            } else {
                float yTop = 1.0 - vUv.y;                       // 0 top -> 1 bottom
                float edge = yTop + uFade.z * nz;               // wavy boundary
                float fade = 1.0 - smoothstep(uFade.x, uFade.y, edge);
                gl_FragColor = vec4(uHole.rgb, uHole.a * mask * fade);
            }
        }
    `;

    function makeHalftone(o) {
        const canvas = document.getElementById(o.canvasId);
        if (!canvas) return;
        const video = o.videoId ? document.getElementById(o.videoId) : null;
        const fade = o.fade || [0, 1, 0];

        const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.5));
        renderer.setClearColor(0x000000, 0);

        const tex = video ? new THREE.VideoTexture(video) : null;
        if (tex) { tex.minFilter = THREE.LinearFilter; tex.magFilter = THREE.LinearFilter; }

        const scene = new THREE.Scene();
        const camera = new THREE.Camera();
        const uniforms = {
            uTex:      { value: tex },
            uRes:      { value: new THREE.Vector2(1, 1) },
            uVid:      { value: new THREE.Vector2(16, 9) },
            uTime:     { value: 0 },
            uGap:      { value: o.gap },
            uAmp:      { value: o.amp },
            uBase:     { value: o.base },
            uScale:    { value: o.scale },
            uUseVideo: { value: video ? 1 : 0 },
            uPattern:  { value: o.pattern ? 1 : 0 },
            uOpaque:   { value: parseColor(o.opaque || 'rgba(0,0,0,0)') },
            uHole:     { value: parseColor(o.hole || 'rgba(0,0,0,0)') },
            uFade:     { value: new THREE.Vector3(fade[0], fade[1], fade[2]) }
        };

        const material = new THREE.ShaderMaterial({
            uniforms, transparent: true, depthTest: false, depthWrite: false,
            vertexShader: `varying vec2 vUv; void main() { vUv = uv; gl_Position = vec4(position.xy, 0.0, 1.0); }`,
            fragmentShader: FRAG
        });
        scene.add(new THREE.Mesh(new THREE.PlaneGeometry(2, 2), material));

        let W = 0, H = 0, running = false, last = 0, rafId = 0;
        function resize() {
            W = canvas.clientWidth; H = canvas.clientHeight;
            renderer.setSize(W, H, false);
            uniforms.uRes.value.set(W, H);
        }
        resize();
        window.addEventListener('resize', resize);

        function syncVid() { if (video && video.videoWidth) uniforms.uVid.value.set(video.videoWidth, video.videoHeight); }
        if (video) { video.addEventListener('loadedmetadata', syncVid); syncVid(); video.play().catch(() => {}); }

        function frame(ts) {
            if (!running) return;
            rafId = requestAnimationFrame(frame);
            if (ts - last < 1000 / FPS) return;
            last = ts;
            uniforms.uTime.value = ts / 1000 * o.speed;
            renderer.render(scene, camera);
        }
        function start() { if (running || reduce) return; running = true; last = 0; rafId = requestAnimationFrame(frame); }
        function stop() { running = false; cancelAnimationFrame(rafId); }

        if ('IntersectionObserver' in window) {
            new IntersectionObserver((es) => { es[0].isIntersecting ? start() : stop(); }, { threshold: 0.01 }).observe(canvas);
        } else { start(); }
        document.addEventListener('visibilitychange', () => { document.hidden ? stop() : start(); });

        if (reduce) renderer.render(scene, camera);   // one static frame
    }

    makeHalftone(Object.assign(
        geom(HERO_DOTSIZE, HERO_GAP, HERO_GRIDSCALE, HERO_VARIATION, HERO_NOISE_SCALE, HERO_SPEED),
        { canvasId: 'heroDots', videoId: 'heroVideo', pattern: false, opaque: HERO_OPAQUE, hole: HERO_HOLE }));
    makeHalftone(Object.assign(
        geom(SEC_DOTSIZE, SEC_GAP, SEC_GRIDSCALE, SEC_VARIATION, SEC_NOISE_SCALE, SEC_SPEED),
        { canvasId: 'sectionDots', pattern: true, hole: SECTION_DOT,
          fade: [SECTION_FADE_START, SECTION_FADE_END, SECTION_FADE_WAVE] }));
})();
