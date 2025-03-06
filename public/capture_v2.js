
document.addEventListener("DOMContentLoaded", function () {
const script = document.createElement('script');
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'; // Path to the JS file you want to include
document.head.appendChild(script);

const script2 = document.createElement('script');
script2.src = 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js'; // Path to the JS file you want to include
script2.onload = function () {
    console.log("Fabric.js loaded successfully.");
    window.fabricCanvas = new fabric.Canvas('fabricCanvas');
};
document.head.appendChild(script2);

const style = document.createElement("style");
style.innerHTML = `
      body { margin: 0; font-family: Arial, sans-serif; }
        .selection-box {
            position: absolute;
            background: rgba(255, 0, 0, 0.2);
            pointer-events: none;
        }
        #editorModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            max-width: 95%; /* Ensure it doesn't exceed 95% of the window width */
            max-height: 95%; /* Ensure it doesn't exceed 95% of the window height */
            overflow: auto; /* Enable scrolling if content overflows */
            box-sizing: border-box;
        }

        #InitialModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            max-width: 95%; /* Ensure it doesn't exceed 95% of the window width */
            max-height: 95%; /* Ensure it doesn't exceed 95% of the window height */
            overflow: auto; /* Enable scrolling if content overflows */
            box-sizing: border-box;
            padding:40px 100px;
        }

        #floating-button {
            position: fixed;
            bottom: 50px;
            right: 0px;
            background: green;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            cursor: pointer;
            transform: rotate(270deg);  /* Rotate the button to make it vertical */
           transform-origin: center; 
           text-decoration: none;
        }
        .overlay { 
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .btn { padding: 5px 10px; margin: 0px; cursor: pointer; }
        .btn-feedback{background-color: green;border:1px solid green;margin-left:5px;color:#fff;border-radius:5px;}
        .feedback-container{display: flex;padding:5px;}
        .take-feedbackScreenshot{cursor:pointer;width:200px;border:1px dotted #000;padding:50px 0;text-align: center;}
        .area-feedbackScreenshot{width: 100%;margin-top:10px;}
        #InitialModal button{background-color: green;border: 1px solid green;color: #fff;padding: 5px;cursor: pointer;}
`;
document.head.appendChild(style);

// Create Initial Modal
const initialModal = document.createElement("div");
initialModal.id = "InitialModal";
initialModal.innerHTML = `
    <div class="take-feedbackScreenshot" onclick="takeScreenShot()">Take Screen Shot</div>
    <div>
        <h4></h4>
        <textarea class="area-feedbackScreenshot"></textarea>
        <p></p>
    </div>
    <button id="uploadBtn">Save</button>
    <button>Cancel</button>
`;

// Create Editor Modal
const editorModalhtml = document.createElement("div");
editorModalhtml.id = "editorModal";
editorModalhtml.innerHTML = `
    <div class="feedback-container">
        <input type="color" id="colorPicker" value="#ff0000" onchange="changeColor()">
        <button class="btn btn-feedback" onclick="addText()">Text</button>
        <button class="btn btn-feedback" onclick="addCircle()">Circle</button>
        <button class="btn btn-feedback" onclick="addLine()">Line</button>
        <button class="btn btn-feedback" onclick="addSquare()">Square</button>
        <button class="btn btn-feedback" onclick="addDrawing()">Draw</button>
        <button class="btn btn-feedback" onclick="deleteObject()">Delete</button>
        <button class="btn btn-feedback" onclick="saveImage()">Save</button>
        <button class="btn btn-feedback" onclick="closeEditor()">Cancel</button>
    </div>
    <canvas id="fabricCanvas"></canvas>
`;

// Create Overlay
const overlayhtml = document.createElement("div");
overlayhtml.className = "overlay";
overlayhtml.id = "overlay";

// Create Floating Button
const floatingButton = document.createElement("a");
floatingButton.id = "floating-button";
floatingButton.href = "javascript:void(0)";
floatingButton.onclick = showInitalModal;
floatingButton.innerText = "Feedback";

// Append elements to body
document.body.appendChild(initialModal);
document.body.appendChild(editorModalhtml);
document.body.appendChild(overlayhtml);
document.body.appendChild(floatingButton);




let startX, startY, endX, endY, selectionBox;
const editorModal = document.getElementById('editorModal');
const InitalModal = document.getElementById('InitialModal');
const overlay = document.getElementById('overlay');
//const fabricCanvas = new fabric.Canvas('fabricCanvas');

const colorPicker = document.getElementById('colorPicker');
let screenshotArray = []; // Array to store multiple screenshots
document.body.addEventListener('mousedown', (e) => {
    if (editorModal.style.display === 'block' || document.body.id !== 'startFeedback') return;

    startX = e.clientX;
    startY = e.clientY;

    selectionBox = document.createElement('div');
    selectionBox.classList.add('selection-box');
    selectionBox.style.left = `${startX}px`;
    selectionBox.style.top = `${startY}px`;
    document.body.appendChild(selectionBox);

    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseup', onMouseUp);
});

function onMouseMove(e) {
    endX = e.clientX;
    endY = e.clientY;

    selectionBox.style.width = `${Math.abs(endX - startX)}px`;
    selectionBox.style.height = `${Math.abs(endY - startY)}px`;
    selectionBox.style.left = `${Math.min(startX, endX)}px`;
    selectionBox.style.top = `${Math.min(startY, endY)}px`;
}

function onMouseUp() {
    document.removeEventListener('mousemove', onMouseMove);
    document.removeEventListener('mouseup', onMouseUp);

    const width = Math.abs(endX - startX);
    const height = Math.abs(endY - startY);

    if (width > 0 && height > 0 && document.body.id === 'startFeedback') {
        html2canvas(document.body, {
            x: Math.min(startX, endX),
            y: Math.min(startY, endY),
            width: width,
            height: height,
            backgroundColor: null,
            scrollX: 0,  // Prevents including the scrolled area
            scrollY: 0,
            useCORS: true // Fixes cross-origin image issues
        }).then(canvas => {
            openEditor(canvas);
        });
    } else {
        console.log("Drag area too small, not capturing.");
    }

    document.body.removeChild(selectionBox);
}


function openEditor(canvas) {
    fabricCanvas.clear();

    const img = new fabric.Image(canvas, {
        left: 0,
        top: 0,
        selectable: false
    });

    fabricCanvas.setWidth(canvas.width);
    fabricCanvas.setHeight(canvas.height);
    fabricCanvas.add(img);
    fabricCanvas.renderAll();

    editorModal.style.display = 'block';
    overlay.style.display = 'block';
}

function showInitalModal(){
    //e.preventDefault();
    editorModal.style.display = 'none';
    InitalModal.style.display = 'block';
    overlay.style.display = 'block';
    //document.body.id="startFeedback";
    
}



window.addText = function() {
    const text = new fabric.Textbox("Enter Text", {
        left: 50,
        top: 50,
        fontSize: 20,
        fill: colorPicker.value,
        borderColor: 'red',
        cornerColor: 'blue',
        cornerSize: 8,
        transparentCorners: false,
        padding: 5
    });
    fabricCanvas.add(text);
    fabricCanvas.setActiveObject(text);
}

window.addCircle = function() {
    const circle = new fabric.Circle({
        left: 100,
        top: 100,
        radius: 50,
        fill: 'transparent', // No fill
        stroke: colorPicker.value, // Use color picker for stroke
        strokeWidth: 5
    });
    fabricCanvas.add(circle);
}

window.addLine = function() {
    const line = new fabric.Line([50, 50, 200, 50], {
        stroke: colorPicker.value,
        strokeWidth: 5
    });
    fabricCanvas.add(line);
}

window.addSquare =function() {
    const square = new fabric.Rect({
        left: 100,
        top: 100,
        width: 100,
        height: 100,
        fill: 'transparent', // No fill
        stroke: colorPicker.value, // Use color picker for stroke only
        strokeWidth: 5
    });
    fabricCanvas.add(square);
}

window.addDrawing = function() {
    fabricCanvas.isDrawingMode = !fabricCanvas.isDrawingMode;
    fabricCanvas.freeDrawingBrush.color = colorPicker.value;
    fabricCanvas.freeDrawingBrush.width = 5;
}

window.deleteObject = function() {
    const activeObject = fabricCanvas.getActiveObject();
    if (activeObject) {
        fabricCanvas.remove(activeObject);
    }
}

window.changeColor=function() {
    const activeObject = fabricCanvas.getActiveObject();
    if (activeObject) {
        if (activeObject.type === 'circle') {
            activeObject.set({ stroke: colorPicker.value });
        } else if (activeObject.type === 'line') {
            activeObject.set({ stroke: colorPicker.value });
        } else if (activeObject.type === 'rect') {
            activeObject.set({ stroke: colorPicker.value }); // Change stroke for square
        } else {
            activeObject.set({ fill: colorPicker.value });
        }
        fabricCanvas.renderAll();
    }
}

window.saveImage = function() {
    const image = fabricCanvas.toDataURL('image/png');
    const link = document.createElement('a');
    let p = document.querySelector('#InitialModal p');  // Select the <p> element inside the element with id="id"
    
    //alert(image);
    //saveScreenshot(canvas);
     link.href = image;
     link.download = 'custom_screenshot.png';
     p.insertAdjacentHTML('beforeend', 'Screenshot.png,'); 
    //link.click();
    //closeEditor();
    screenshotArray.push(fabricCanvas.toDataURL('image/png'));
    closeEditor();
    takeScreenShot();
    InitalModal.style.display = 'block';
    overlay.style.display = 'block';
    document.body.removeAttribute('id');
}





window.takeScreenShot = function(){
    document.body.id="startFeedback";
    closeEditor();
    

}

window.closeEditor=function() {
    editorModal.style.display = 'none';
    overlay.style.display = 'none';
    InitalModal.style.display = 'none';
    
}



document.getElementById('uploadBtn').addEventListener('click', function () {

    const scripts = document.getElementsByTagName("script");
        let scriptSrc = "";

        for (let script of scripts) {
            if (script.src.includes("capture_v2.js")) {
                scriptSrc = script.src;
                break;
            }
        }

// Parse the URL and get the query parameter 's'
const urlParams = new URL(scriptSrc).searchParams;
const val = urlParams.get("s");
    let text = "Some text data"; // Example text data
    let extraVariable = val; // Another variable

    sendData(text, screenshotArray, extraVariable);
});

function sendData(text, images, extraVar) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "upload.php", true); // Replace with your server-side script URL
    xhr.setRequestHeader("Content-Type", "application/json");

    // Prepare the data
    let data = JSON.stringify({
        text: text,
        images: images, // Directly use the screenshotArray
        extraVar: extraVar
    });

    // Send the request
    xhr.send(data);

    // Handle the response
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Success:", xhr.responseText);
        } else {
            console.error("Error:", xhr.statusText);
        }
    };

    xhr.onerror = function () {
        console.error("Request failed.");
    };
}

});