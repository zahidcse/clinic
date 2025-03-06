const script=document.createElement("script");script.src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js",document.head.appendChild(script);const script2=document.createElement("script");script2.src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js",document.head.appendChild(script2);const style=document.createElement("style");style.innerHTML=`
     #floating-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: red;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 50%;
    cursor: pointer;
}
#screenshot-preview {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    max-width: 800px;
    max-height: 600px;
    margin: 0 auto;
    background-color: #f4f4f4;
    padding: 10px;
    border-radius: 10px;
    box-sizing: border-box;
    overflow: hidden;
}
canvas {
    width: 100%;
    height: 100%;
    border: 1px solid #000;
}
.toolbar {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 10px;
}
.toolbar button{background:green;color:white}
.toolbar button,
.toolbar input {
    margin: 5px;
}
#caption {
    width: 100%;
    padding: 5px;
    margin-top: 10px;
}
#save-btn {
    margin-top: 10px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
`,document.head.appendChild(style),window.onload=function(){let e=document.createElement("button");e.id="floating-button",e.innerHTML="\uD83D\uDCF7",document.body.appendChild(e);let t=document.createElement("div");t.id="screenshot-preview",document.body.appendChild(t);let n=document.createElement("div");n.className="toolbar",t.appendChild(n);let i=document.createElement("button");i.innerHTML="Free Draw",i.onclick=function e(){$.isDrawingMode=!$.isDrawingMode},n.appendChild(i);let l=document.createElement("button");l.innerHTML="Write Text",l.onclick=function e(){$.isDrawingMode=!1;let t=new fabric.Textbox("Write here",{left:50,top:50,fill:m,fontSize:20,editable:!0});$.add(t)},n.appendChild(l);let o=document.createElement("button");o.innerHTML="Draw Circle",o.onclick=function e(){h="circle",$.isDrawingMode=!1;let t=new fabric.Circle({left:100,top:100,radius:30,fill:"transparent",stroke:m,strokeWidth:2});$.add(t)},n.appendChild(o);let r=document.createElement("button");r.innerHTML="Draw Line",r.onclick=function e(){let t=new fabric.Line([50,50,200,200],{stroke:m,strokeWidth:2});$.add(t)},n.appendChild(r);let a=document.createElement("button");a.innerHTML="Delete",a.onclick=function e(){let t=$.getActiveObject();t&&$.remove(t)},n.appendChild(a);let d=document.createElement("input");d.type="color",d.id="colorPicker",d.value="#ff0000",n.appendChild(d);let c=document.createElement("input");c.type="text",c.id="caption",c.placeholder="Enter caption",t.appendChild(c);let p=document.createElement("button");p.id="save-btn",p.innerHTML="Save",t.appendChild(p);let s=document.createElement("canvas");s.id="canvas",t.appendChild(s);let $=new fabric.Canvas("canvas");$.setWidth(800),$.setHeight(600);let h=null,b=[],m="#ff0000";function g(){b.length>0&&$.loadFromJSON(b.pop(),$.renderAll.bind($))}document.getElementById("floating-button").addEventListener("click",()=>{html2canvas(document.body,{ignoreElements:e=>"floating-button"===e.id}).then(e=>{let t=800/e.width,n=600/e.height;$.clear();let i=new fabric.Image(e,{left:0,top:0,selectable:!1,scaleX:t,scaleY:n});$.add(i),document.getElementById("screenshot-preview").style.display="block"})}),document.getElementById("save-btn").addEventListener("click",()=>{let e=document.getElementById("caption").value;fetch("/save-screenshot",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({image:$.toDataURL("image/png"),caption:e})}).then(e=>e.json()).then(e=>{alert("Screenshot saved!"),document.getElementById("screenshot-preview").style.display="none"})}),document.getElementById("colorPicker").addEventListener("input",function(e){m=e.target.value;let t=$.getActiveObject();t&&("text"===t.type||"textbox"===t.type?t.set({fill:m}):"circle"===t.type||"rect"===t.type?t.set({stroke:m,fill:"transparent"}):"line"===t.type&&t.set({stroke:m}),$.renderAll())})};