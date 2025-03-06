const script = document.createElement('script');
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'; // Path to the JS file you want to include
document.head.appendChild(script);

const script2 = document.createElement('script');
script2.src = 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js'; // Path to the JS file you want to include
document.head.appendChild(script2);

const style = document.createElement("style");
style.innerHTML = `
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
    max-width: 60%;
    width: 60%;
    max-height: auto;
    margin: 0 auto;
    background-color: #f4f4f4;
    padding: 10px;
    border-radius: 10px;
    box-sizing: border-box;
    overflow: hidden;
    position:absolute;
    z-index:999999;
    top:10%;
    left:20%;
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
`;
document.head.appendChild(style);
// Dynamically create and insert HTML elements
window.onload = function() {
    // Create floating button
    const floatingButton = document.createElement("button");
    floatingButton.id = "floating-button";
    floatingButton.innerHTML = "📷";
    document.body.appendChild(floatingButton);

    // Create screenshot preview container
    const screenshotPreview = document.createElement("div");
    screenshotPreview.id = "screenshot-preview";
    document.body.appendChild(screenshotPreview);

    // Create toolbar inside the screenshot preview
    const toolbar = document.createElement("div");
    toolbar.className = "toolbar";
    screenshotPreview.appendChild(toolbar);

    const freeDrawButton = document.createElement("button");
    freeDrawButton.innerHTML = "Free Draw";
    freeDrawButton.onclick = toggleDrawingMode;
    toolbar.appendChild(freeDrawButton);

    const writeTextButton = document.createElement("button");
    writeTextButton.innerHTML = "Write Text";
    writeTextButton.onclick = enableTextMode;
    toolbar.appendChild(writeTextButton);

    const drawCircleButton = document.createElement("button");
    drawCircleButton.innerHTML = "Draw Circle";
    drawCircleButton.onclick = enableCircleMode;
    toolbar.appendChild(drawCircleButton);

    const drawLineButton = document.createElement("button");
    drawLineButton.innerHTML = "Draw Line";
    drawLineButton.onclick = enableLineMode;
    toolbar.appendChild(drawLineButton);

   // const undoButton = document.createElement("button");
   // undoButton.innerHTML = "Undo";
   // undoButton.onclick = undo;
   // toolbar.appendChild(undoButton);

    const deleteButton = document.createElement("button");
    deleteButton.innerHTML = "Delete";
    deleteButton.onclick = deleteSelected;
    toolbar.appendChild(deleteButton);

    //const saveButton = document.createElement("button");
   // saveButton.id = "save";
   // saveButton.innerHTML = "Save Image";
    //toolbar.appendChild(saveButton);

   // const colorLabel = document.createElement("label");
    //colorLabel.innerHTML = "Select Color: ";
   // toolbar.appendChild(colorLabel);

    const colorPicker = document.createElement("input");
    colorPicker.type = "color";
    colorPicker.id = "colorPicker";
    colorPicker.value = "#ff0000";
    toolbar.appendChild(colorPicker);

    // Create caption input and save button
    const captionInput = document.createElement("input");
    captionInput.type = "text";
    captionInput.id = "caption";
    captionInput.placeholder = "Enter caption";
    screenshotPreview.appendChild(captionInput);

    const saveCaptionButton = document.createElement("button");
    saveCaptionButton.id = "save-btn";
    saveCaptionButton.innerHTML = "Save";
    screenshotPreview.appendChild(saveCaptionButton);

    // Create canvas
    const canvasElement = document.createElement("canvas");
    canvasElement.id = "canvas";
    screenshotPreview.appendChild(canvasElement);



const canvas = new fabric.Canvas('canvas');
canvas.set('backgroundColor', '#ccc');
canvas.renderAll();
    


const maxWidth = 800; // Max width for the canvas
const maxHeight = 600; // Max height for the canvas

// Resize the canvas to predefined dimensions
canvas.setWidth(maxWidth);
canvas.setHeight(maxHeight);

let drawingMode = null;
let history = [];
let currentColor = "#ff0000";

document.getElementById('floating-button').addEventListener('click', () => {
    html2canvas(document.body, {
        ignoreElements: element => element.tagName === 'CANVAS' || element.id === 'floating-button'
    }).then(imageCanvas => {
        // Get the original width and height of the screenshot
        const originalWidth = imageCanvas.width;
        const originalHeight = imageCanvas.height;

        // Set the max width for the canvas (adjust as needed)
        const maxWidth = 800;

        // Scale the image proportionally
        const scale = maxWidth / originalWidth;
        const scaledWidth = maxWidth;
        const scaledHeight = originalHeight * scale; // Auto height based on aspect ratio

        // Resize canvas to match the new image size
        canvas.setWidth(scaledWidth);
        canvas.setHeight(scaledHeight);
        

        // Convert screenshot to a Fabric image object
        const img = new fabric.Image(imageCanvas, {
            left: 0,  // Center horizontally
            top: 0,
            selectable: false,
            scaleX: scale, // Maintain aspect ratio
            scaleY: scale
        });
        canvas.clear();
        // Add the image to the canvas
        canvas.add(img);
        canvas.set('backgroundColor', '#ccc');
        canvas.renderAll();
       


        // Show the screenshot preview area
        document.getElementById('screenshot-preview').style.display = 'block';
    });
});


/*document.getElementById('floating-button').addEventListener('click', () => {
    html2canvas(document.body, { ignoreElements: element => element.id === 'floating-button' }).then(imageCanvas => {
        // Resize the screenshot to fit the canvas size (scale it down)
        const scaleX = maxWidth / imageCanvas.width;
        const scaleY = maxHeight / imageCanvas.height;

        // Clear the canvas before adding the screenshot
        canvas.clear();

        // Create a fabric image object from the screenshot
        const img = new fabric.Image(imageCanvas, {
            left: 0,
            top: 0,
            selectable: false,
            scaleX: scaleX, // Scale the image to fit the canvas width
            scaleY: scaleY  // Scale the image to fit the canvas height
        });

        // Add the image to the canvas
        canvas.add(img);

        // Show the screenshot preview area
        document.getElementById('screenshot-preview').style.display = 'block';
    });
});
*/
document.getElementById('save-btn').addEventListener('click', () => {
    let caption = document.getElementById('caption').value;
    let imageData = canvas.toDataURL("image/png");
    fetch('/save-screenshot', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ image: imageData, caption: caption })
    }).then(response => response.json()).then(data => {
        alert('Screenshot saved!');
        document.getElementById('screenshot-preview').style.display = 'none';
    });
});

function toggleDrawingMode() {
    canvas.isDrawingMode = !canvas.isDrawingMode;
}

function enableTextMode() {
    canvas.isDrawingMode = false;
    let text = new fabric.Textbox("Write here", {
        left: 50,
        top: 50,
        fill: currentColor,
        fontSize: 20,
        editable: true
    });
    canvas.add(text);
    
}

function enableCircleMode() {
    drawingMode = "circle";
    canvas.isDrawingMode = false;
    let circle = new fabric.Circle({
        left: 100,
        top: 100,
        radius: 30,
        fill: 'transparent',
        stroke: currentColor,
        strokeWidth: 2
    });
    canvas.add(circle);
}

function enableLineMode() {
    let line = new fabric.Line([50, 50, 200, 200], {
        stroke: currentColor,
        strokeWidth: 2
    });
    canvas.add(line);
}

function undo() {
    if (history.length > 0) {
        canvas.loadFromJSON(history.pop(), canvas.renderAll.bind(canvas));
    }
}

function deleteSelected() {
    const activeObject = canvas.getActiveObject();
    if (activeObject) {
        canvas.remove(activeObject);
    }
}

document.getElementById("colorPicker").addEventListener("input", function(event) {
    currentColor = event.target.value;
    const activeObject = canvas.getActiveObject();
    if (activeObject) {
        // Apply color change based on selected object type
        if (activeObject.type === 'text' || activeObject.type === 'textbox') {
            activeObject.set({ fill: currentColor });
        } else if (activeObject.type === 'circle' || activeObject.type === 'rect') {
            activeObject.set({ stroke: currentColor, fill: 'transparent' });
        } else if (activeObject.type === 'line') {
            activeObject.set({ stroke: currentColor });
        }
        canvas.renderAll();
    }
});

}