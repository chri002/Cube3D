<html>
	<head>
		<title>Starting Code for 1st Project 2017</title>
		<style>
		:root{
			--alpha : 90deg;
		}
		body {
			font-family: Monospace;
			background-color: #f0f0f0;
			margin: 0px;
			overflow: hidden;
		}
		
		canvas { 
			width: 100%; 
			height: 100%;
		}
		
		#Orologio{
			background-image	: URL("textures/dayNightOro.png");
			position 			: absolute;
			top					: -18%;
			left				: -18%;
			background-size		: cover; 
			-webkit-transform:rotate(90eg);
			-moz-transform: rotate(90deg);
			-ms-transform: rotate(90deg);
			-o-transform: rotate(90deg);
			transform: rotate(90deg);
			z-index 			: 5;
		}
		
		#Timee{
			background-image	: URL("textures/dayNightClock.png");
			position 			: absolute;
			top					: -18%;
			left				: -18%;
			background-size		: cover; 
			-webkit-transform:rotate(var(--alpha));
			-moz-transform: rotate(var(--alpha));
			-ms-transform: rotate(var(--alpha));
			-o-transform: rotate(var(--alpha));
			transform: rotate(var(--alpha));
			z-index 	: 1;
		}
	
	</style>

		<script id="fragmentBussola" type="glsl/x-fragment">
			float PI = 3.1415926535897932384626433832795;
			
			uniform sampler2D tex;
			uniform sampler2D bacText;
			uniform sampler2D shadText;
			uniform float alpha;
			varying vec2 vUv;
			varying vec3 vPosition;
			varying vec3 vNormal;
				
			vec2 rotate(float alpha1,vec2 uVu){
				float med = 0.5;
				return vec2(
					cos(alpha1) * (uVu.x - med) + sin(alpha1) * (uVu.y - med) + med,
					cos(alpha1) * (uVu.y - med) - sin(alpha1) * (uVu.x - med) + med
				);
			}

			void main() {
				vec2 uVu = rotate(alpha, vUv);
				float shaderFactor = dot(vNormal, vec3(2., 1., 1.));
				
				
				
				vec4 color = texture2D(tex, uVu);
				vec4 color2 = texture2D(shadText, vUv);
				vec4 colorSotto = texture2D(bacText,  rotate(PI, vUv));
				vec4 colorBase = vec4(vec3(0.8,0.6,0.0)*(shaderFactor),1.0);
				
				if(vPosition.y>=0.2){
					if(colorSotto.g<=(colorSotto.r+0.1) && (colorSotto.b+0.1)>=colorSotto.g){
						if(color.a>0.1)
							gl_FragColor = color;
						else
							gl_FragColor = colorSotto;
					}else{
						gl_FragColor = colorBase+(color2);
					}
				}else
					gl_FragColor = colorBase;
			}
			
		</script>
		<script id="fragmentButton" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float alpha;
			varying vec2 vUv;
			varying vec3 vPosition;
			varying vec3 vNormal;
				
			

			void main() {
				vec2 uVu  = vUv;
				float shaderFactor = dot(vNormal, vec3(0.255, 0.67, 0.8));
				float med = 0.5;
				uVu = vec2(
					cos(alpha) * (uVu.x - med) + sin(alpha) * (uVu.y - med) + med,
					cos(alpha) * (uVu.y - med) - sin(alpha) * (uVu.x - med) + med
				);
				
				vec4 color = texture2D(tex, uVu);
				vec4 colorBase = vec4(vec3(1.0)*shaderFactor,1.0);
				
				
				if(vPosition.y>0.499)
					
					if(color.a>0.5)
						gl_FragColor = color;
					else{ 
						gl_FragColor = vec4(vec3(1.0-abs(max(max(vPosition.x, min(vPosition.x,vPosition.z)), vPosition.z))),1.0);
						
					}
				else 
					if(vPosition.x<-0.4999 || vPosition.x>0.4999)
						gl_FragColor = vec4(vec3((1.0-abs(vPosition.z))),1.0);
					else if(vPosition.z<-0.4999 || vPosition.z>0.4999)
						gl_FragColor = vec4(vec3((1.0-abs(vPosition.x)))*shaderFactor,1.0);
					else
						gl_FragColor = vec4(colorBase.rgb, 1.0);
			}
			
		</script>
		<script id="fragmentSnow" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;
			uniform vec3 LightColor;

			varying vec2 vUv;
			varying vec3 vNormal;
			
			vec3 light; 
				
			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}
			

			void main() {
				light =   LightColor;
				vec4 color = texture2D(tex, vUv);
				vec2 st = vUv.xy;
				

				st *= 15.0; 			
				vec2 ipos = floor(st);  
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( gl_FragCoord.xy*0.75+vec2(sin(delta*25.0)))));
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				
				color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
				
				if(randV.x>0.95 && rand.x>0.9 && shade_factor>0.4)
					gl_FragColor = 1.15*shade_factor*vec4(1.,1.,1.,1.0)*max(0.85,(sin(delta)+0.5));
				else{
					gl_FragColor = vec4(vec3(dot(color.rgb, vec3(0.299, 0.587, 0.114)))*1.35,1.0);
					gl_FragColor = (gl_FragColor+vec4(light/1.5, 1.0))/2.;
				}
				
				
			}
			
		</script>
		<script id="fragmentSand" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;
			uniform vec3 LightColor;

			varying vec2 vUv;
			varying vec3 vNormal;
			
			vec3 light; 
				
			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}
			

			void main() {
				light =  LightColor;
				vec4 color = texture2D(tex, vUv);
				vec2 st = vUv.xy;
				

				st *= 12.; 			
				vec2 ipos = floor(st);  
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( gl_FragCoord.xy*0.7+vec2(sin(delta*25.0)))));
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				
				color = color*shade_factor*max(min((sin(mod(delta,3.14))/1.15),0.4), 0.85);
				
				
				if(randV.x>0.95 && rand.x>0.9 && shade_factor>0.4)
					gl_FragColor = 1.3*vec4(1.0,0.85,0.1,1.0)*max(0.85,(sin(delta)+0.5));
				else{
					gl_FragColor = color;
					//gl_FragColor = vec4(color.r*light.r+color.r/4., color.g*light.g+color.g/4., color.b*light.b +color.b/4.,1.0);
				}
			}
			
		</script>
		<script id="fragmentBadRock" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;
			uniform vec3 LightColor;

			varying vec2 vUv;
			varying vec3 vNormal;
			
			vec3 light; 
				
			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}
			

			void main() {
				light =   LightColor;
				vec4 color = texture2D(tex, vUv);
				vec2 st = vUv.xy;
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				
				color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
				
				gl_FragColor = color;
				
			}
			
		</script>
		<script id="fragmentWater"  type="glsl/x-fragment">
			
			uniform float delta;
			uniform vec3 lightPos;
			uniform vec3 LightColor;
			
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;

			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}

			void main()
			{
				vec4 color1= vec4(0.4,0.6,0.8,1.0);
				vec4 colorbase;
				vec4 colorSec;
				vec4 color;

				vec2 st = vUv.xy+vec2(delta,0.0);
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
							
				st *= 80.0; 			
				vec2 ipos = floor(st);  
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( vUv.xy*80.0+vec2((delta*35.0)))));
				
				colorbase = vec4(color1.xyz, rand.x*randV.x+0.6);
				
				if(rand.x*randV.x<=0.8)
					color = colorbase;
				else
					color = vec4(1.0);
				gl_FragColor = vec4((color.rgb*(max(0.2,(sin(delta)/2.0)+0.5)+(vec3(max(0.,min(1.0,0.5-vPosition.z)))))),color.a);
			}
		</script>
		<script id="fragmentExplosion" type="glsl/x-fragment">
			uniform sampler2D tex;
			uniform sampler2D texColor;
			
			
			uniform float  delta;
			
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			

			void main() {
				vec4 dcolor = texture2D (tex, vUv);
				float d = (dcolor.r) * 0.5;
				
				if(d*delta<-0.2) discard;
				if(d*delta>0. && d/delta<0.3) discard;
				
				vec4 c = texture2D( texColor, vec2(d,0.5));
				
				gl_FragColor = c.rgba + c.rgba* c.a;
				
			}
		</script>
		<script id="fragmentMeteora" type="glsl/x-fragment">
			uniform sampler2D tex;
			uniform float delta;
			uniform vec3 lightPos;

			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			vec3 light; 
				
			float random (vec2 st) {
				return fract(sin(dot(st.xy,
									 vec2(12.9898,78.233)))*
					43758.5453123);
			}
			

			void main() {
				light =   vec3(0.9, 0.5, 0.2);
				vec4 color = texture2D(tex, vUv);
				vec2 st = vUv.xy;
				
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				
				st *= 1.0; 			
				vec2 ipos = floor(st);  
				vec2 fpos = fract(st);  // get the fractional coords
				vec4 rand = vec4(random( ipos ));
				vec4 randV= vec4(random(floor( gl_FragCoord.xy*0.25+vec2(sin(delta*2.)*5., cos(delta*2.)*5.))));
				
				color = randV*vec4(vec3(min(color.r, min(color.g, color.b))),1.0);
				
				if(color.r>0.15)
					gl_FragColor = vec4(vec3(light),1.);
				else
					gl_FragColor = color*shade_factor;
				
			}
			
		</script>
		<script id="fragmentGrass" type="glsl/x-fragment">
			
			uniform sampler2D tex;
			uniform sampler2D texLato;
			uniform float delta;
			uniform vec3 lightPos;
			uniform vec3 LightColor;

			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			vec3 light; 
			
			

			void main() {
				float shade_factor = 0.25 + 1.3 * max(0.0, dot(vNormal, normalize(lightPos)/1.75));
				vec4 color;
				
				light =   ((LightColor/1.5)+vec3(0.2,0.8,0.2))/2.;
								
				
				if(vPosition.y>0.45){
					vec2 uVu = vUv+(vec2(pow(2.72,sin(delta*30.5)/8.0)/3.5*sin(delta*10.0)/3.0, pow(2.72,sin(delta*20.5)/4.0)/2.0))/2.0;
					color = texture2D(tex, uVu);
					
					color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
					gl_FragColor = vec4(color.xyz*light,1.0);
				}else{
					color = texture2D(texLato, vUv);
					
					color = color*shade_factor*max(min((sin(delta)/1.15),0.4), 0.85);
				
					gl_FragColor = vec4(color.xyz,1.0);
				}
			}
			
		</script>
		<script id="vertexGrass" type="glsl/x-vertex">
			uniform sampler2D tex;
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			void main() {
				vUv = uv;
				vNormal = normal.xyz;
				vPosition = position.xyz;
				
				gl_Position =   projectionMatrix * modelViewMatrix *vec4(position,1.0);
			}
		</script>
		<script id="vertexWater" type="glsl/x-vertex">
			
			uniform sampler2D tex;
			uniform float delta;
			uniform float waveX;
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			void main() {
				vUv = uv;
				vNormal = normal.xyz;
				vPosition = position.xyz;
				
				if(waveX!=0. && position.y>-5.5 && position.y<5. && position.x>-5. && position.x<5.5)
					gl_Position =   projectionMatrix * modelViewMatrix *(vec4(position,1.0)+(vec4(0.,0.,(waveX*cos(position.x+delta*10.)*sin(position.y)/2.)+waveX,0.)));
				else
					gl_Position =   projectionMatrix * modelViewMatrix *(vec4(position,1.0));
				
			
				
			}
		</script>
		<script id="vertexExplosion" type="x-shader/x-vertex">
			uniform sampler2D  tex;
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			
			uniform float delta;
			
			void main() {
				vUv = uv;
				vNormal = normal;
				vPosition = position.xyz;
				
				vec4 dcolor = texture2D( tex, vUv);
				float d = (dcolor.r);
				
				
				gl_Position =   projectionMatrix * modelViewMatrix *vec4(position*(1.+delta),1.0);
				gl_Position.xyz +=  normal*(d * delta)*0.4;
			}
		</script>
		<script id="vertex" type="glsl/x-vertex">
			
			uniform sampler2D tex;
			varying vec2 vUv;
			varying vec3 vNormal;
			varying vec3 vPosition;
			
			void main() {
				vUv = uv;
				vNormal = normal.xyz;
				vPosition = position;
				
				gl_Position =   projectionMatrix * modelViewMatrix *vec4(position,1.0);
			}
		</script>
		
		<script src="lib/three.min.js"></script>
		<script src="lib/stats.min.js"></script>
		<script src="lib/Coordinates.js"></script>
		<script src="lib/OrbitControls.js"></script>
		<script src="lib/GLTFLoader.js"></script>
		<script src="lib/postprocessing.min.js"></script>
	</head>
	<body>
		<div id="Orologio">
		</div>
		<div id="Timee">
		</div>
		<script>
		
		var scene, renderer, stats, camera, data, sun, bussola;
		var gX, gZ;
		var vista, x, zoom, rotateA, timeEx;
		var waveX;
		var isRunningAction;
		var isDay;
		var loadState;
		
		var geometry;
		var material;
		var esplosionMesh;
		var texture;
		var materialSand;
		var materialBadRock;
		var materialSnow;
		var materialWater;
		var materialGrass;
		var materialButton;
		var materialBussola;
		var materialExplosion;
		var materialMeteora;
		
		var cube,cropWorld;
		var touchableItem;
		
		var clWS, clAD;
		
		var raycaster;
		var mousePos;
		var mousePressed;
		
		var debugTest 	= { worldSize:0.0, sectionSize: 0.0, stateOfDay:0.0, positionWorld:[0.0,0.0]};
		var command	 	= { terrainUp: true, terrainDown:false, terremoto:false, meteorite:false, onda:false};
		var Person;
		
		//DOcument.getElementById(id) => i(id)
		//REQUIRE ID of element, String
		//RETURN Element if exist
		function i(id){
			return document.getElementById(id);
		}
		
		//return height from image
		//REQUIRE img, path of image 
		//REQUIRE scale, scale of height
		//RETURN data, array of int
		function getHeightData(img,scale) {
  
		 if (scale == undefined) scale=1;
  
		    var canvas = document.createElement( 'canvas' );
		    canvas.width = img.width;
		    canvas.height = img.height;
		    var context = canvas.getContext( '2d' );
 
		    var size = img.width * img.height;
			//console.log("World size: "+size);
			debugTest.worldSize = size;
		    var data = new Float32Array( size );
 
		    context.drawImage(img,0,0);
 
		    for ( var i = 0; i < size; i ++ ) {
		        data[i] = 0
		    }
 
		    var imgd = context.getImageData(0, 0, img.width, img.height);
		    var pix = imgd.data;
 
		    var j=0;
		    for (var i = 0; i<pix.length; i +=4) {
		        var all = pix[i]+pix[i+1]+pix[i+2];  // all is in range 0 - 255*3
		        data[j++] = scale*all/3;   
		    }
			
		    return data;
		}
		
		//initiate button near world(left)
		function initiateButton(){
			var button = [];
			var parteSoto;			
			
			for(var idx=0; idx<18; idx++){
				switch(idx){
					case 4:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/punto.png")}, alpha: {type:"f", value:0.0}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 9:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/alza.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 10:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/terremoto.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 11:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/bassa.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 12:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/AClock.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 13:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/meterora.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 14:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/piu.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 15:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/Clock.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 16:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/wave.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					case 17:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/meno.png")}, alpha: {type:"f", value:Math.PI/4}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
						break;
					default:
						materialButton	= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/arrow.png")}, alpha: {type:"f", value:idx*Math.PI/8}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
				}
				
				button.push(new THREE.Mesh(new THREE.CubeGeometry(1), materialButton));
				
				button[idx].position.set(parseInt(idx/3),0,parseInt(idx%3));
				button[idx].scale.set(1,1,1);
				
				touchableItem.add(button[idx]);
			}
			
			button[0].material.uniforms.alpha.value = 2*Math.PI/8;
			button[1].material.uniforms.alpha.value = 4*Math.PI/8;
			button[2].material.uniforms.alpha.value = 6*Math.PI/8;
			button[3].material.uniforms.alpha.value = 0;
			button[5].material.uniforms.alpha.value = 8*Math.PI/8;
			button[6].material.uniforms.alpha.value = -2*Math.PI/8;
			button[7].material.uniforms.alpha.value = -4*Math.PI/8;
			button[8].material.uniforms.alpha.value = -6*Math.PI/8;
			
			scene.add(touchableItem);
			touchableItem.position.set(-8,2.5,1.5);
		}	
		
		//initiate terrain from image(textures/heightmap2.png)
		function initiateTerrain(){
			
			
			var img = new Image();
			img.src = "textures/heightmap2.png";
			img.onload = function(){
				//get height data from img
				data = getHeightData(img,0.03);
				updateTerrainVis();
				loadState++;
			}
		}
		
		//initiate all variable
		function initiate(){
			
			gX 	= 5;
			gZ  = 5;
			x   = 0;
			zoom     = 1.5;
			rotateA  = 0;
			vista 	 = 5;
			waveX    = +vista+2;
			timeEx	 = 0;
			loadState= 0;
			
			isRunningAction = false;
			isDay			= true;
			
			geometry 				= new THREE.BoxGeometry(1,1,1);
			material 				= new THREE.MeshPhongMaterial( { color: 0xaaaaaa } );
			texture					= new THREE.ImageUtils.loadTexture("textures/sand.jpg");
			materialSand 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}, LightColor : {type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentSand").innerHTML});
			materialBadRock			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}, LightColor : {type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentBadRock").innerHTML});
			materialSnow 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}, LightColor : {type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentSnow").innerHTML});
			materialMeteora			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentMeteora").innerHTML});
			materialWater 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, waveX : {type:"f", value:0.0},lightPos : {type:'v3',value:new THREE.Vector3(1.0,1.0,1.0)}, delta : {type:"f", value:0.0}, LightColor : {type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertexWater").innerHTML, fragmentShader:i("fragmentWater").innerHTML, transparent : true});
			materialGrass 			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:texture}, texLato : {type:'t',value:THREE.ImageUtils.loadTexture("textures/grassLato.jpg")},LightPosition : {type:'v3',value:new THREE.Vector3()}, delta : {type:"f", value:0.0}, lightPos:{type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}, LightColor : {type:"v3", value:new THREE.Vector3(1.0,1.0,1.0)}}, vertexShader:i("vertexGrass").innerHTML, fragmentShader:i("fragmentGrass").innerHTML, transparent : true});
			materialButton			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/arrow.png")}, alpha: {type:"f", value:0.0}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentButton").innerHTML, transparent:true});
			materialBussola			= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/bussolaN.png")}, bacText : {type:'t',value:THREE.ImageUtils.loadTexture("textures/bussolaSotto.png")}, shadText: {type:'t',value:THREE.ImageUtils.loadTexture("textures/bussolaB.png")}, alpha: {type:"f", value:Math.PI}}, vertexShader:i("vertex").innerHTML, fragmentShader:i("fragmentBussola").innerHTML, transparent:true});
			materialExplosion		= new THREE.ShaderMaterial( { uniforms: {tex : {type:'t',value:THREE.ImageUtils.loadTexture("textures/noiseExplose.png")}, texColor: {type:'t',value:THREE.ImageUtils.loadTexture("textures/colorExplsion.png")}, delta: {type:"f", value:Math.PI}}, vertexShader:i("vertexExplosion").innerHTML, fragmentShader:i("fragmentExplosion").innerHTML, transparent:true});
					
			
			clWS	= true;
			clAD	= true;
			
			raycaster    = new THREE.Raycaster();
			mousePos     = new THREE.Vector2();
			mousePressed = false;
			
			sun 			= new THREE.DirectionalLight(0xddddff, 1.5);
			scene 			= new THREE.Scene();
			camera 			= new THREE.OrthographicCamera(-window.innerWidth/64*zoom, window.innerWidth/64*zoom, window.innerHeight/44*zoom, -window.innerHeight/44*zoom, 0.01, 400);
			touchableItem 	= new THREE.Object3D();
			//stats 			= new Stats();
			renderer 		= new THREE.WebGLRenderer( {antialias: true} );
			bussola			= new THREE.Mesh(new THREE.CylinderGeometry(1,1,0.5,32), materialBussola);
			
			Person = loading("models/Person.gltf");
			
			renderer.setSize( window.innerWidth, window.innerHeight );
			renderer.setClearColor( 0x040404 );
			renderer.shadowMapEnabled 		 = true;																			
			renderer.shadowMap.type   		 = THREE.PCFSoftShadowMap;
			renderer.physicallyCorrectLights = true;
			
			materialGrass.uniforms.tex.value.wrapS  = THREE.RepeatWrapping;
			materialGrass.uniforms.tex.value.wrapT  = THREE.RepeatWrapping;
						
			//stats.domElement.style.position = 'absolute';
			//stats.domElement.style.top 		= '0px';
			
			esplosionMesh = new THREE.Mesh(new THREE.SphereGeometry(1,64,64), materialExplosion);
			
			resetCommand();
			initiateTerrain();
			
			
		}
		
		//Select material from heigth
		//REQUIRE posY value of y position
		//RETURN material
		function materiale(posY){
			if(posY==0)
				return new THREE.Mesh(geometry, materialBadRock);
			else if(posY<=3)
				return new THREE.Mesh(geometry, materialSand);
			else if(posY<=5)
				return new THREE.Mesh( geometry, materialGrass );
			else 
				return new THREE.Mesh( geometry, materialSnow );
			
		}
		
		//modify terrain from position (data axis) and height value to add or subtruct
		//REQUIRE position, position inside data axis
		//REQUIRE value, value to add, or subtruct if negative
		function modifyTerrainHigh(position,value){
			var sqrt = Math.sqrt(data.length);
			//console.log(position);
			if(data[position.x+position.z*sqrt]+value>0 && data[position.x+position.z*sqrt]<10)
				if(position.x>=0 && position.x<sqrt &&	
					position.z>=0 && position.z<sqrt){
						data[position.x+position.z*sqrt]+=value;
						updateTerrainVis();
					}
		}
	
		//update terrain for updating
		function updateTerrainVis(){
			
			cube 		    = new THREE.Mesh( geometry, material );
			cropWorld	    = new THREE.Object3D();
			if(data!=null){
				var sqrt = Math.sqrt(data.length);
				var iniX = Math.max(0,gX-vista), iniZ = Math.max(0,gZ-vista);
				var maxX = Math.min(sqrt,gX+vista), maxZ = Math.min(sqrt,gZ+vista);
				
				for(var ix=iniX; ix<maxX; ix++){
					for(var iz=iniZ; iz<maxZ; iz++){
						for(var i2=0; i2<data[ix+iz*sqrt]; i2++){	
								
								cube = materiale(i2);
								
								cube.position.set((ix-gX+0.5), i2, (iz-gZ+0.5));
								cube.castShadow = true;
								cube.receiveShadow = true;
								cropWorld.add(cube);
							
							
						}
					}
				}
			}
			//console.log("CropSize: "+cropWorld.children.length);
			debugTest.sectionSize = cropWorld.children.length;
			debugTest.position = {"0":gX, "1":gZ};
			
			cropWorld.position.set(-vista-0.5, 0,- vista-0.5);
			cropWorld.rotation.y = rotateA;
			scene.children[1].rotation.z=rotateA;
			scene.children[0]=(cropWorld);
		}
	
		//Main function
		//create sea and table and bussola
		//!!create a intereval to manage the loadState for lunching update()!!
		function Start() {			
			var ambient =  new THREE.DirectionalLight(0xaaaaaa, 1);
			
			initiate();
			
			scene.add(new THREE.Object3D());
			scene.add(new THREE.Object3D());
							
			document.body.appendChild( renderer.domElement );
			//document.body.appendChild( stats.domElement );
			document.getElementById("Orologio").style.width  = window.innerWidth/10*4;
			document.getElementById("Orologio").style.height = window.innerWidth/10*4;
			document.getElementById("Timee").style.width	 = window.innerWidth/10*4;
			document.getElementById("Timee").style.height 	 = window.innerWidth/10*4;
			
			scene.add(sun);
			scene.add(ambient);
			
			
			ambient.position.set(10, 5,10);
			
			camera.position.set(-1, 12, -1);
			camera.rotation.set(-1.137, 0.398, 0.666);
			
			var sea   = new THREE.Mesh(new THREE.PlaneGeometry(vista*2+2,vista*2+2,320,320), materialWater);
			var table = new THREE.Mesh(new THREE.PlaneGeometry(20,20), new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("textures/table_alpha.png"),transparent:true}));
			
			
			sea.rotation.set(-Math.PI/2, 0, 0);
			sea.position.set(-vista-0.6, 2.4, -vista-0.6);
			scene.children[1] = (sea);
			
			table.rotation.set(-Math.PI/2, 0, 0);
			table.position.set(-5,2.5,-5);
			scene.add(table);
			
			bussola.position.set(2.5, 3, -2*vista-2.5);
			scene.add(bussola);
						
			initiateButton();
			onWindowResize();
			
			var intervalloLoad = setInterval(function(){
				console.log("Stato: "+(loadState*50));
				if(loadState==2){
					clearInterval(intervalloLoad);
					
					Update();
				}
				
			}, 1000);
		}
		
		var t=0;
		//function update
		//update shader, sun position, time variable ( x ) and call render
		function Update() {
			requestAnimationFrame( Update ); 
			
			sunUpdate();
			shaderUpdate();
			
			//Update del camminatore
			Person.update();
						
			Render();
			x=Date.now()/10000%(2*Math.PI);
			isDay=(x>=Math.PI);
			debugTest.stateOfDay = ((x/(2*Math.PI)*24+16.5)%24);
		}
		
		//update sun position and color
		function sunUpdate(){
			
			sun.position.set(-vista, Math.abs(Math.sin(x)*(vista*20)), Math.cos((isDay? x:x+Math.PI))*(vista*20));
			
			if(isDay){
				sun.color.r = Math.min(1, Math.max(0.0,Math.abs(Math.sin(x))*0.9));
				sun.color.g = Math.min(1, Math.max(0.0,Math.abs(Math.sin(x))*0.9));
				sun.color.b = Math.min(1, Math.max(0.0,Math.abs(Math.sin(x))*0.8));
			}else{
				sun.color.r = Math.min(1, Math.max(0.0,Math.abs(Math.sin(x))*0.7));
				sun.color.g = Math.min(1, Math.max(0.0,Math.abs(Math.sin(x))*0.7));
				sun.color.b = Math.min(1, Math.max(0.0,Math.abs(Math.sin(x))*0.9));
			}
			
			document.documentElement.style.setProperty('--alpha', x+'rad')
			
			
		}
		
		//update shader variable
		//delta = time 
		//lightPos = position of sun
		function shaderUpdate(){
			materialSand.uniforms.delta.value = (isDay? x:x+Math.PI);
			materialWater.uniforms.delta.value = x;
			materialGrass.uniforms.delta.value = x;
			materialSnow.uniforms.delta.value = (isDay? x:x+Math.PI);
			materialWater.uniforms.delta.value = x;
			materialExplosion.uniforms.delta.value = (timeEx=timeEx+0.1)%3;
			
			materialBussola.uniforms.alpha.value = rotateA+Math.PI;
			
			materialSand.uniforms.lightPos.value = sun.position;
			materialGrass.uniforms.lightPos.value = sun.position;
			materialSnow.uniforms.lightPos.value = sun.position;
			materialWater.uniforms.lightPos.value = sun.position;
			
			
			materialSand.uniforms.LightColor.value = sun.color;
			materialGrass.uniforms.LightColor.value = sun.color;
			materialSnow.uniforms.LightColor.value = sun.color;
			materialWater.uniforms.LightColor.value = sun.color;
			
		}
		
		
		//RENDER--
		function Render() {
			
			renderer.render(scene, camera);
		}
		
		//switch action for terrain height and meteora
		function actionFunction(action){
			if(command.terrainUp){
				modifyTerrainHigh(new THREE.Vector3(parseInt(action.position.x+gX), action.position.y, parseInt(action.position.z+gZ)), +1);
			}else if(command.terrainDown){
				modifyTerrainHigh(new THREE.Vector3(parseInt(action.position.x+gX), action.position.y, parseInt(action.position.z+gZ)), -1);
			}else if(command.meteorite){
				meteoraAction(action.position);
			}
			
			
		}
		
		
		//reset position y of button (left table)
		function resetAllBTN(){
			
			for(var i=0; i<touchableItem.children.length; i++){
				touchableItem.children[i].position.y=0;
			}
		}
		
		//reset command variable
		function resetCommand(){
			command.terrainUp	= false;
			command.terrainDown	= false;
			command.terremoto	= false;
			command.meteorite	= false;
			command.onda		= false;
		}
		
		
		//function to manage terremoto
		//!! Create interval and destroy it !!
		//update terrain height but not save it
		//animate x,y all terrain position, return origin position at the and
		function terremotoAction(){
			if(!isRunningAction){
				isRunningAction = true;
				
				var scala = Math.random()*10;
				var stato = 0;
				var xT = 0, zT = 0;
				var sqrt = Math.sqrt(data.length);
				
				var intervallo = setInterval(function(){
						if(stato/20>=scala){
							cropWorld.position.set(0,0,0);
							updateTerrainVis();
							isRunningAction=false;
							resetAllBTN();
							resetCommand();
							clearInterval(intervallo);
							return;
						}else{
							xT = parseInt((Math.random()-0.5)*2*vista);
							zT = parseInt((Math.random()-0.5)*2*vista);
							var valY = parseInt((Math.random()-0.5)*3);
							modifyTerrainHigh(new THREE.Vector3((gX+xT),0,(gZ+zT)),valY);
							cropWorld.position.set((-vista-0.333)+Math.sin(x*1000)/10*scala/3,0,(-vista-0.333)+Math.cos(x*1000)/10*scala/3);
							stato += 0.5;
						}					
					},50);
			}
		}
		
		//function to manage tzunami
		//!! Create interval and destroy it !!
		//animate y vertex of sea, return vertex y origin at the and
		function waveAction(){
			if(!isRunningAction){
				isRunningAction = true;
				
				var time=0;
				
				var intervallo = setInterval(function(){
						if(time>10){
							clearInterval(intervallo);
							isRunningAction=false;
							resetAllBTN();
							resetCommand();
							materialWater.uniforms.waveX.value=0;
							return;
						}else{
							if(time<=2)
								materialWater.uniforms.waveX.value+=0.05;
							if(time>=8)
								materialWater.uniforms.waveX.value-=0.05;
							time+=0.1;
						}		
					},100);
			}
		}
		
		
		//function to manage meteora
		//!! Create interval and destroy it !!
		//!! Create cube(meteora) and destroy it !!
		//create a hole in terrain
		//REQUIRE positione, position of relative world(cropWorld axis)
		function meteoraAction(positione){
			if(!isRunningAction){
				isRunningAction = true;
				//console.log(positione);
				var time=0;
				var meteora = new THREE.Mesh(geometry, materialMeteora);
				var pos = positione.clone();
				var piv = new THREE.Object3D();
				var scos= new THREE.Vector3(gX, 0 , gZ);
				pos.x+=gX-0.5;
				pos.z+=gZ-0.5;
				//console.log(positione);
				
				meteora.position.set((positione.x),15, (positione.z));
				piv.position.set(-vista-0.5, 0,- vista-0.5)
				piv.add(meteora);
				piv.rotation.y = rotateA;
				scene.add(piv);
				
				var intervallo = setInterval(function(){
						if(meteora.position.y<=pos.y){
							var piEx = new THREE.Object3D();
							timeEx = 0;
							esplosionMesh.position.set(meteora.position.x+0.5, meteora.position.y+1.5, meteora.position.z+0.5);
							esplosionMesh.rotation.y = -rotateA;
							piEx.add(esplosionMesh);
							piEx.position.set(-vista-0.5, 0,- vista-0.5)
							piEx.rotation.y = rotateA;
							scene.add(piEx);
							var intervalloEsplosione=setInterval(function(){
								if(timeEx>2.5){
									clearInterval(intervalloEsplosione);
									scene.remove(piEx);
									isRunningAction=false;
									resetAllBTN();
									resetCommand();
								}
								
							}, 25);
							clearInterval(intervallo);
							scene.remove(piv);
							createCratere(pos,3);
							
							return;
						}else{
							meteora.position.y-=time;
							meteora.position.x =positione.x+scos.x-gX;
							meteora.position.z =positione.z+scos.z-gZ;
							piv.rotation.y = rotateA;
							time+=0.25;
						}		
					},100);
			}
		}
		
		//create a hole inside terrain
		//REQUIRE pos position inside data axis
		//REQUIRE n, ~ size of hole
		function createCratere(pos, n){
			var sqrt = Math.sqrt(data.length);
			//console.log("posizione1: ");
			//console.log(pos);
			for(var i2=0; i2<n; i2++){
				for(var i=-n+i2+1; i<n-i2; i++){
					for(var iz=-n+i2+1; iz<n-i2; iz++){
						if(data[(i+pos.x)+(iz+pos.z)*sqrt]>1)
							data[(i+pos.x)+(iz+pos.z)*sqrt]-=1;
					}
				}
			}	
			updateTerrainVis();
		}
		
		//Va a visualizzare con la camera il camminatore
		//!!modifica posizione gX gZ
		function puntaCamminatore(){
			gX = Math.floor(Person.positionData[0]);
			gZ = Math.floor(Person.positionData[2]);
		}
		
		//manage button click(left world button)
		//require position of button world axis
		function buttonAction(action){
						
			
			
			switch(action.position.x){
				case 0:
					buttonAnimation(action);
					switch(action.position.z){
						case 0:
							directionAction(1);
							break;
						case 1:
							directionAction(0);
							break;
						case 2:
							directionAction(7);
							break;
					}
					break;
				case 1:
					buttonAnimation(action);
					switch(action.position.z){
						case 0:
							directionAction(2);
							break;
						case 1:
							puntaCamminatore();
							break;
						case 2:
							directionAction(6);
							break;
					}
					break;
				case 2:
					buttonAnimation(action);
					switch(action.position.z){
						case 0:
							directionAction(3);
							break;
						case 1:
							directionAction(4);
							break;
						case 2:
							directionAction(5);
							break;
					}
					break;
				case 3:
					if(!isRunningAction){
						resetAllBTN();
						resetCommand();
						switch(action.position.z){
							case 0:
								command.terrainUp = true;
								action.position.y=-0.3;
								break;
							case 1:
								command.terremoto = true;
								action.position.y=-0.3;
								terremotoAction();
								break;
							case 2:
								command.terrainDown = true;
								action.position.y=-0.3;
								break;
						}
						break;	
					}
				case 4:
					
					switch(action.position.z){
						case 0:
							buttonAnimation(action);
							rotateA += Math.PI/2;
							break;
						case 1:
							if(!isRunningAction){
								resetAllBTN();
								resetCommand();
								command.meteorite = true;
								action.position.y=-0.3;
							}
							break;
						case 2:
							buttonAnimation(action);
							zoom+=0.05;
							break;
					}
					break;	
				case 5:
					
					switch(action.position.z){
						case 0:
							buttonAnimation(action);
							rotateA -= Math.PI/2;
							break;
						case 1:
							if(!isRunningAction){
								resetAllBTN();
								resetCommand();
								command.wave = true;
								action.position.y=-0.3;
								waveAction();
							}
							break;
						case 2:
							buttonAnimation(action);
							zoom-=0.05;
							break;
					}
					break;		
			}
			
			
			gX=lim(gX, vista, Math.sqrt(data.length)-vista);
			gZ=lim(gZ, vista, Math.sqrt(data.length)-vista);
			updateTerrainVis();
			onWindowResize();
			
			
		}
	
		//animate button click
		//REQUIRE button clicked
		function buttonAnimation(btn){
			btn.position.y = -0.2;
			var intervallo = setInterval(function(){
				if(btn.position.y>=0)
				{
					clearInterval(intervallo);
					btn.position.y=0;
				}else 
					btn.position.y+=0.075;
			},100);
		}
		
		//animate terrain move 
		//REQUIRE dir, 0 = north, 1 = north-est, 2 = est, ... , 6 = west, 7 = nort-west
		function directionAction(dir){
			switch(dir){
				case 0:
					if(rotateA%Math.PI==0)
						gX+=-Math.cos(rotateA);
					else
						gZ+=-Math.sin(rotateA);
					break;
				case 1:
					if(rotateA%Math.PI==0){
						gX+=-Math.cos(rotateA);
						gZ+=-Math.cos(rotateA);
					}else{
						gZ+=-Math.sin(rotateA);
						gX+=Math.sin(rotateA);
					}break;
				case 2:
					if(rotateA%Math.PI==0)
						gZ+=-Math.cos(rotateA);
					else
						gX+=Math.sin(rotateA);
					break;
				case 3:
					if(rotateA%Math.PI==0){
						gZ+=-Math.cos(rotateA);
						gX+=Math.cos(rotateA);
					}else{
						gX+=Math.sin(rotateA);
						gZ+=Math.sin(rotateA);
					}
					break;
				case 4:
					if(rotateA%Math.PI==0)
						
						gX+=Math.cos(rotateA);
					else
						gZ+=Math.sin(rotateA);
					break;
				case 5:
					if(rotateA%Math.PI==0){
						gX+=Math.cos(rotateA);
						gZ+=Math.cos(rotateA);
					}else{
						gZ+=Math.sin(rotateA);
						gX+=-Math.sin(rotateA);
					}
					break;
				case 6:
					if(rotateA%Math.PI==0)
						gZ+=Math.cos(rotateA);
					else
						gX+=-Math.sin(rotateA);
					break;
				case 7:
					if(rotateA%Math.PI==0){
						gZ+=Math.cos(rotateA);
						gX+=-Math.cos(rotateA);
					}else{
						gX+=-Math.sin(rotateA);
						gZ+=-Math.sin(rotateA);
					}
					break;
			}
			gX=lim(gX, vista, Math.sqrt(data.length)-vista);
			gZ=lim(gZ, vista, Math.sqrt(data.length)-vista);
			updateTerrainVis();
			onWindowResize();
			
		}
		
		//Listener 
		window.addEventListener( 'resize', onWindowResize, false );
		document.addEventListener("keydown", onDocumentKeyDown, false);
		document.addEventListener("keyup", function(e){ 
												if(e.which==83 || e.which==87) clWS=true;
												if(e.which==68 || e.which==65) clAD=true;
											}, false);
		document.addEventListener( 'mousemove', onDocumentMouseMove, false );
		document.addEventListener( 'mousedown', onDocumentMouseDown, false );    
		document.addEventListener( 'mouseup', onDocumentMouseUp, false );


		//resize window when page is resize or when zoom in/out
		function onWindowResize(){
			
			
			var aspect =  window.innerWidth / window.innerHeight;
			aspect = (aspect>=1? 1:aspect)*zoom;
			camera.left   = -window.innerWidth/(64*aspect);
			camera.right  =  window.innerWidth/(64*aspect);
			camera.top    =  window.innerHeight/(48*aspect);
			camera.bottom = -window.innerHeight/(48*aspect);
			
			camera.updateProjectionMatrix();

			renderer.setSize( window.innerWidth, window.innerHeight );
			
			
			document.getElementById("Orologio").style.width  = window.innerWidth/10*2;
			document.getElementById("Orologio").style.height = window.innerWidth/10*2;
			document.getElementById("Timee").style.width	 = window.innerWidth/10*2;
			document.getElementById("Timee").style.height 	 = window.innerWidth/10*2;
			
			document.getElementById("Orologio").style.top    = -window.innerWidth/10;
			document.getElementById("Orologio").style.left   = -window.innerWidth/10;
			document.getElementById("Timee").style.top  	 = -window.innerWidth/10;
			document.getElementById("Timee").style.left 	 = -window.innerWidth/10;
		}
		
		//manage keyboard button
		//WASD to move, +,- to zoom
		function onDocumentKeyDown(event) {
							
				var keyCode = event.which;
				if (keyCode == 87 && clWS) {
					directionAction(2);
					click=false;
				} else if (keyCode == 83 && clWS) {
					directionAction(6);
					click=false;
				}
				if (keyCode == 65 && clAD) {
					directionAction(0);
					click=false;
				} else if (keyCode == 68 && clAD) {
					directionAction(4);
					click=false;
				} 
				
				if(keyCode == 107 || keyCode == 171){
					zoom += 0.05;
					onWindowResize();
				}else if(keyCode == 109 || keyCode == 173){
					zoom -= 0.05;
					onWindowResize();
				}
				
				if(keyCode == 69){
					rotateA -= Math.PI/2;
					updateTerrainVis();
				}else if(keyCode==81){
					rotateA += Math.PI/2;
					updateTerrainVis();
				}
				
				
			}		
		
		//manage click inside world
		//button and terrain
		function onDocumentMouseDown( event ) { 
			mousePressed=true;
			
			raycaster.setFromCamera( mousePos.clone(), camera );   
			
			var objects = raycaster.intersectObjects(touchableItem.children);
				var o = [];
			if (objects.length>0) {
				for (var i=0; i<objects.length; i++) {
				   	o.push(objects[i].object.uuid);
					
				}
				o = o.length>0 ? o[0] : -1;
			} else {
				objects = raycaster.intersectObjects(cropWorld.children);
				o = [];
				if (objects.length>0) {
					for (var i=0; i<objects.length; i++) {
						o.push(objects[i].object.uuid);
						
					}
					o = o.length>0 ? o[0] : -1;
				} 
				else
					o = o.length>0 ? o[0] : -1;
			} 
			
			
			if(mousePressed){
				for(var i=0; i<cropWorld.children.length; i++) {
							
							if (cropWorld.children[i].uuid===o) {
								actionFunction(cropWorld.children[i].clone());
								mousePressed = false;
							} 
					}
				for(var i=0; i<touchableItem.children.length; i++) {
							
							if (touchableItem.children[i].uuid===o) {
								buttonAction(touchableItem.children[i]);
								mousePressed = false;
							} 
					}
			}
		}
		
		//end press
		function onDocumentMouseUp( event ) { mousePressed = false;}
		
		//mouse position
		function onDocumentMouseMove( event ) {
			mousePos.x = ( event.clientX / window.innerWidth ) * 2 - 1;
			mousePos.y = - ( event.clientY / window.innerHeight ) * 2 + 1;
		}

		//crop function
		function lim(val, min, max){
			return Math.min(max, Math.max(val, min));
		}
		
		
				
		//Read Armature of model
		//REQUIRE root bone(at begin model)
		//REQUIRE s array with other bone
		//RETURN Armature
		function ricorso(root, s){
			s[root.name] = root;
			
			if(root.children.length>0)
				for(var i=0; i<root.children.length; i++){
					s=ricorso(root.children[i],s);
				}
			return s;
		}
		
		//Create Armature
		//REQUIRE root model
		//RETURN Armature
		function MappaOssatura(root){
			var Armatura = { head: null, armL:null, armR:null, handL:null, handR:null, legL:null, legR:null};
			
			return ricorso(root, {});
		}
		
		//Read model
		//REQUIRE path position
		//!!Add to scene the Object
		function loading(path){
			var loader = new THREE.GLTFLoader(); 
			
			loader.load(path,
					function (gltf){
						var modello = {model:null, material:Array(), armature:Array()};
	
						//console.info(gltf);
					
						modello.model = gltf.scene.children[0];
						
						//console.log(modello.model.children[4]);
						
						modello.material.push(modello.model.children[4].material);
						modello.castShadow = true;
						modello.receiveShadow = true;
						modello.material[0].normalScale = {x:0.5, y:0.5};
						modello.material[0].metalness = 0;
						
						
						modello.armature = MappaOssatura(modello.model);
						//console.info(modello);
						Person = Entity(modello);
						
						scene.add(Person.Mesh.model);
						
						loadState++;
						
					}, undefined, function (error){
						console.error(error);
					});
			}
			
			
		//Oggetto Del Camminatore errante
		//REQUIRE model mesh del camminatore
		//RETURN obj{ Mesh::mesh del camminatore, positionData: posizione del camminatore, update()::funzione di aggiornamento}
		//!!Crea tre intervall : uno che dura per tutto il tempo e calcola la posizione  ogni 2500ms,
		//      il secondo per l'animaione ogni 200ms, rimosso al termine dell'animazione
		//		il terzo per l'animazione di teletrasporto
		function Entity(model){
			model.model.scale.set(0.3,0.6,0.3);
			var modello = model;
			var sqrt = Math.sqrt(data.length);
			var pos =  {"0":parseInt(Math.random()*sqrt),"1":0,"2":parseInt(Math.random()*sqrt)};
			var dire = function(d){
				var x=0,z=0,yr=0;
				switch(d){
					case 0:
						z--;
						yr=Math.PI/2;
						break;
					case 1:
						x--;
						yr=Math.PI;
						break;
					case 2:
						z++;
						yr=-Math.PI/2;
						break;
					case 3:
						x++;
						yr=0;
						break;
					default:
						break;
				}
				return {"x":x, "z":z, "yR":yr};
			};
			
			
			var timeMove = setInterval(
				function(){
					var dir = dire(parseInt(Math.random()*5));
					var newPos = {"0":dir["x"],"1": 0,"2": dir["z"]};
					if(newPos[0]+ pos[0]>0.2 && newPos[0]+ pos[0]<sqrt-0.2 	&& 
						newPos[2]+ pos[2]>0.2 && newPos[2]+ pos[2]<sqrt-0.2 && 
						data[parseInt((newPos[0]+ pos[0]))+parseInt((newPos[2]+ pos[2]))*sqrt]>=2 && 
						Math.abs(data[parseInt(pos[0])+parseInt(pos[2])*sqrt]-data[parseInt(newPos[0]+ pos[0])+parseInt(newPos[2]+ pos[2])*sqrt])<1.25){
						  
						 modello.model.rotation.y = dir["yR"];
						 //console.log(modello.model.rotation); 
						var tt=0;
						var intervalloAnimazione = setInterval(function(){
							if(tt>15 || (newPos[0]==0 && newPos[2]==0)){
								clearInterval(intervalloAnimazione);
								
								modello.armature.LL.rotation.z = 0;
								modello.armature.LLH.rotation.z = 0;
								modello.armature.LR.rotation.z = 0;
								modello.armature.LRH.rotation.z = Math.PI;
								
								return;
							}else{								
								pos[0] = (newPos[0]/14+ pos[0]);
								pos[2] = (newPos[2]/14+ pos[2]);
								var v=Math.PI/3*tt;
								modello.armature.LL.rotation.z = (-(Math.sin(v))<0? Math.abs(Math.sin(v)):0)/2;
								modello.armature.LLH.rotation.z = -(Math.sin(v))/2;
								modello.armature.LR.rotation.z = ((Math.PI-(Math.cos(v)))<Math.PI? Math.abs(Math.cos(v)):0)/2;
								modello.armature.LRH.rotation.z = Math.PI-(Math.cos(v))/2;
								}
							tt++;
							
						}, 100);
						modello.model.position.set((pos[0]-gX),pos[1]+0.3,pos[2]-gZ);
					}else{
						if(data[parseInt((newPos[0]+ pos[0]))+parseInt((newPos[2]+ pos[2]))*sqrt]<2){
							clearInterval(timeMove);
							clearInterval(intervalloAnimazione);
							var timeE=0;
							var teleportIntervall = setInterval(function(){
								if(timeE>10){
									clearInterval(teleportIntervall);
									Person = Person.reset(model);
								}else{
									modello.model.rotation.y+=Math.PI/4;
								}
								timeE++;
							}, 50);
						}
					}
					
				},2500);
					
			
			return { Mesh : modello,
			positionData : pos,
			update:function(){
				pos[1] = Math.floor(data[Math.floor( pos[0])+Math.floor(pos[2])*sqrt]+1);
				if(pos[0]<Math.max(0, gX-vista) || pos[0]>Math.min(sqrt, gX+vista-0.5) || pos[2]<Math.max(0, gZ-vista) || pos[2]>Math.min(sqrt, gZ+vista-0.5))
					cropWorld.remove(modello.model);
				else 
					cropWorld.add(modello.model);
				
				modello.model.position.set((pos[0]-gX),pos[1]+0.3,pos[2]-gZ);
				
			},reset:function(){
				return Entity(model);
			}};
			
		}
		
	
		
		Start();
			
		</script>
	</body>
</html>