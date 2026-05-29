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