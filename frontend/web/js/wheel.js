$("#modifywheel").click(function () {
    $('html, body').animate({
        scrollTop: $("#wheelBuilder").offset().top
    }, 1000);
});

var colors = ["#FFFF00", "#FFFFFF", "#3333FF", "#FFFFFF", "#FF2222", "#FFFFFF"];
//var restaurants = ["American", "Pizza", "Italian", "Mexican", "Spanish", "Caribbean", "Seafood", "Mediterranean", "French", "Indian", "Chinese", "Thai", "Vietnamese", "Korean", "Japanese", "Sandwiches", "Burgers", "Breakfast"];
var intTextBox = 100;
var choiceCount = 100;
var numcolors = colors.length;


//FUNCTION TO ADD TEXT BOX ELEMENT
function addElement() {
    if (choiceCount < 100 && intTextBox < 200) {
        intTextBox = intTextBox + 1;
        choiceCount = choiceCount + 1;
        var contentID = document.getElementById('txtChoices');
        var newTBDiv = document.createElement('div');
        newTBDiv.setAttribute('id', 'strText' + intTextBox);
        newTBDiv.setAttribute('class', 'input-group');
        newTBDiv.innerHTML = "<input onfocus='addElementIfNeeded(" + intTextBox + ")' class='form-control' type='text' id='c" + intTextBox + "' name='c" + intTextBox + "'/><span class='input-group-btn' id='basic-addon2'><input type='button' value='X' onclick='removeElementID(" + intTextBox + ");' tabindex='1000'></span>";
        contentID.appendChild(newTBDiv);
    } else {
        alert("Number of wheel slices cannot exceed 100. Visit our Business page to purchase a wheel beyond 100 slices.");
    }
}

function addElementIfNeeded(id) {
    if (id == intTextBox) {
        addElement();
    }
}

//FUNCTION TO REMOVE TEXT BOX ELEMENT
function removeElement() {
    if (intTextBox != 0) {
        var contentID = document.getElementById('txtChoices');
        contentID.removeChild(document.getElementById('strText' + intTextBox));
//intTextBox = intTextBox-1; this would break it
        choiceCount = choiceCount - 1;
    }
}

function removeElementID(cnum) {
    var contentID = document.getElementById('txtChoices');
    contentID.removeChild(document.getElementById('strText' + cnum));
    //intTextBox = intTextBox-1; this would break it
    choiceCount = choiceCount - 1;
}

intTextBox = 5;
choiceCount = intTextBox;
var weights = [];

function setWeightedVariables() {
    numOptionsWeighted = restaurants.length;
    if (weights.length > 0) {
        for (var i = 0; i < weights.length; i++) {
            numOptionsWeighted += weights[i] - 1;
        }
    }
    arc = Math.PI / (numOptionsWeighted / 2);
    wedgeAngle = Math.PI * 2 / numOptionsWeighted;
}

var numcolors = colors.length;
var numoptions = restaurants.length;

var numOptionsWeighted;
var arc;

setWeightedVariables();

if (numOptionsWeighted % 2 == 1) {
    isOddNumberOfChoices = true;
    isFirstSpinCycle = true;
}

var canv = document.getElementById("wheelcanvas");
var canvTop = document.getElementById("wheelcanvastop");


var isMobile = false;
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    isMobile = true;
}

if (isMobile) {
    canvasWidth = canv.width;
    var mutebutton = document.getElementById('mutebutton');
    toggleMute(mutebutton);
}
if (window.frameElement) {
    maxWidth = window.frameElement.offsetWidth;
    maxHeight = window.frameElement.offsetHeight;
}
var minDimension = Math.min(maxWidth, maxHeight);

if (!isMobile) {
    var canvasWidth = 500;
    canv.width = canvasWidth;
    canv.height = canvasWidth;
    wheelSize = canvasWidth;
    canvTop.width = canvasWidth;
    canvTop.height = canvasWidth;
    var canvOuter = document.getElementById('wheelcanvasOuter');
    canvOuter.style.width = canvasWidth + "px";
    canvOuter.style.height = canvasWidth + "px";

    var context = canvTop.getContext('2d');
    var imageObj = new Image();

    imageObj.onload = function () {
        context.drawImage(imageObj, 0, 0, canvasWidth, canvasWidth);
    };
    imageObj.src = '/images/WD-Click-to-Spin.png';

}

var wheelRadius = wheelSize * 0.5;
var outsideRadius = wheelRadius;
var textRadius = wheelRadius * 0.9;
var insideRadius = wheelRadius * 0.1;

function wheelMouseDown(e) {
    clearTopCanvas();
    drawArrow();
    var wheeldiv = document.getElementById("wheelcanvastop");
    midX = wheeldiv.offsetLeft + wheelRadius + wheeldiv.offsetParent.offsetLeft + wheeldiv.offsetParent.offsetParent.offsetLeft;
    midY = wheeldiv.offsetTop + wheelRadius + wheeldiv.offsetParent.offsetTop + wheeldiv.offsetParent.offsetParent.offsetTop;
    lastX = e.clientX;
    lastY = e.clientY;
    isMouseDown = true;
}

function drawRouletteWheel() {
    var canvas = document.getElementById("wheelcanvas");
    if (canvas.getContext) {

        ctx = canvas.getContext("2d");
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.clearRect(0, 0, canv.width, canv.height);
        ctx.strokeStyle = "black";
        ctx.lineWidth = 0;
        ctx.translate(canvas.width / 2, canvas.height / 2);
        ctx.font = 'bold 12px sans-serif';
        var weightedIndex = 0;

        for (var i = 0; i < numoptions; i++) {
            var weightedArc = arc;
            var weight = 1;
            if (weights.length > i) {
                weight = weights[i];
                weightedArc = arc * weight;
            }

            var angle = startAngle + weightedIndex * arc;
            ctx.fillStyle = colors[i % numcolors];
            ctx.beginPath();
            var endAngle = angle + weightedArc;
            // Chrome 43.0.2357.81 m arc issue
            if (endAngle > 6.282 && endAngle < 6.284) {
                endAngle = 6.282;
            }
            ctx.arc(0, 0, outsideRadius, angle, endAngle, false);
            ctx.arc(0, 0, insideRadius, endAngle, angle, true);
            ctx.fill();
            ctx.save();


            ctx.fillStyle = "black";
            var angHalfArc = angle + weightedArc * 0.5 - 0.04;
            ctx.translate(Math.cos(angHalfArc) * textRadius, Math.sin(angHalfArc) * textRadius);
            ctx.rotate(angHalfArc + Math.PI);
            var text = restaurants[i];

            ctx.font = 'bold ' + choiceTextSize[i] + 'px sans-serif';

            textHWidth = ctx.measureText(text).width;
            if (textHWidth > textRadius - 30) {
                text = text.substring(0, 27) + "...";
            }


            ctx.fillText(text, 0, 0);
            weightedIndex += weight;
            ctx.restore();
        }

        drawArrow();
    }
}

function spin() {
    clearTopCanvas();
    drawArrow();
    var minTimeToSpin = 5;
    var timeRange = 4;
    var minAngleToStartRotating = 20;
    var angleRange = 30;
    spinTime = 0;
    spinTimeTotal = minTimeToSpin * 1000;
    angleSinceBeep = 0;
    timeSinceBeep = 0;

    slowDown = false;
    spinAngleStart = Math.random() * angleRange + minAngleToStartRotating;
    setWheelImageSource();
    rotateWheelImage();
}

function setChoiceFontSizes() {
    // get the font size of each choice
    var canvas = document.getElementById("wheelcanvas");
    if (canvas.getContext) {
        ctx = canvas.getContext("2d");
        choiceTextSize = [];
        for (var i = 0; i < numoptions; i++) {
            var text = restaurants[i];
            ctx.font = 'bold 18px sans-serif';
            var textHWidth = ctx.measureText(text).width;
            if (textHWidth > textRadius - 30) {
                ctx.font = 'bold 15px sans-serif';
                textHWidth = ctx.measureText(text).width;
                if (textHWidth > textRadius - 30) {
                    choiceTextSize.push("12");
                } else {
                    choiceTextSize.push("15");
                }
            } else {
                choiceTextSize.push("18");
            }
        }


    }
}


function stopRotateWheelImage() {
    clearTimeout(spinTimeout);

    var choice = getCurrentChoiceWithWeights();
    var text = choice.text;
    var index = choice.index;

    var canvasTop = document.getElementById("wheelcanvastop");
    if (canvasTop.getContext) {

        ctxTop = canvasTop.getContext("2d");

        ctxTop.font = 'bold 30px sans-serif';
        var textHWidth = ctxTop.measureText(text).width * 0.5;
        if (textHWidth > wheelRadius) {
            ctxTop.font = 'bold 12px sans-serif';
            textHWidth = ctxTop.measureText(text).width * 0.5;
        }

        var imageObj = new Image();

        imageObj.onload = function () {
            ctxTop.drawImage(imageObj, 0, 0, canvasWidth, canvasWidth);
            ctxTop.fillStyle = "white";
            ctxTop.fillText(text, canvasWidth / 2 - textHWidth, canvasWidth / 2 + 10);
        };
        imageObj.src = '/images/stop-message-gradient-500.png';
        if (!isMuted) {
            var audioFinal = document.getElementById("wheelAudioFinal");
            audioFinal.play();
        }
    }


}

addTouchEventListeners();
draw();