const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const camera = document.getElementById("camera");
const cameraWaiting = document.getElementById("cameraWaiting");
const uploadFilePart = document.getElementById("uploadFilePart");
const takeSnapshotButton = document.getElementById("takePhoto");
const sendPictureButton = document.getElementById("sendPicture");
const chooseUploadPictureButton = document.getElementById("chooseUploadPicture");
const uploadPictureButton = document.getElementById("uploadPicture");
const savePictureForm = document.getElementById("savePicture");
const confirmationButtons = document.getElementById("confirmationButtons");
const chooseButtons = document.getElementById("chooseButtons");
const cancelButton = document.getElementById("cancelButton");

const inputFile = document.getElementById("selectFile");

const filterPart = document.getElementById("filterPart");
const filterSelectInput = document.getElementById("filterSelectInput");
const uploadTypeInput = document.getElementById("uploadTypeInput");

const cenaFilter = document.getElementById("cenaFilter");
const dassinFilter = document.getElementById("dassinFilter");
const hallidayFilter = document.getElementById("hallidayFilter");
const knoxvilleFilter = document.getElementById("knoxvilleFilter");
const lennonFilter = document.getElementById("lennonFilter");
const pesciFilter = document.getElementById("pesciFilter");

const imageWidthDesired = 600;
const imageHeightDesired = 600;

var filtersSelected = [];

var snapshotDisabled = false;

navigator.mediaDevices.enumerateDevices()
    .then(function (devices) {
        const videoDevices = devices.filter(function (device) {
            return device.kind === "videoinput";
        });
        if (videoDevices.length > 0) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    if (stream) {
                        cameraWaiting.style.display = "none";
                        camera.style.display = "flex";
                        video.srcObject = stream;
                        video.play();
                    }
                })
                .catch(function (err) {
                    takeSnapshotButton.disabled = true;
                    snapshotDisabled = true;
                    alert("An error occurred: " + err);
                });
        } else {
            canvas.style = "display: block";
            canvas.width = video.getBoundingClientRect().width;
            canvas.height = video.getBoundingClientRect().height;
            video.style = "display: none";
            takeSnapshotButton.disabled = true;
            snapshotDisabled = true;
            alert("No video devices found");
        }
    })
    .catch(function (err) {
        alert(err.name + ": " + err.message);
    });

takeSnapshotButton.addEventListener('click', function () {
    if (!video.srcObject.active) {
        alert("No video devices found");
        location.reload();
    }
    drawCanvas(video, video.videoWidth, video.videoHeight);
    let image_data_url = canvas.toDataURL('image/png');
    if (!image_data_url) {
        alert('error !image_data_url');
    }
    const dataURLInput = document.getElementById('dataURLInput');
    dataURLInput.value = image_data_url;
    video.style.display = 'none';
    chooseButtons.style.display = 'none';
    canvas.style.display = 'flex';
    confirmationButtons.style.display = 'flex';
});

chooseUploadPictureButton.addEventListener('click', function () {
    video.style.display = 'none';
    chooseButtons.style.display = 'none';
    uploadFilePart.style.display = 'flex';
    confirmationButtons.style.display = 'flex';
    uploadTypeInput.value = true;
    if (sendPictureButton.disabled)
        sendPictureButton.disabled = false;
});

cancelButton.addEventListener('click', function () {
    canvas.style.display = 'none';
    confirmationButtons.style.display = 'none';
    uploadFilePart.style.display = 'none';
    video.style.display = 'flex';
    chooseButtons.style.display = 'flex';
    filterSelectInput.value = "";
    uploadTypeInput.value = false;
});

inputFile.addEventListener('change', async function () {
    var files = inputFile.files;
    if (files == undefined || files.length != 1) {
        alert('error with file selection');
        return;
    }
    var curFile = files[0];
    const valid = await validFileType(curFile);
    if (!valid) {
        alert('error invalid type file');
        location.reload();
    }
    var size = returnFileSize(curFile.size);
    var image = new Image();
    image.src = window.URL.createObjectURL(curFile);
    image.onload = function () {
        drawCanvas(image, image.width, image.height);
        let image_data_url = canvas.toDataURL('image/png');
        if (!image_data_url) {
            alert('error !image_data_url');
        }
        const dataURLInput = document.getElementById('dataURLInput');
        dataURLInput.value = image_data_url;
    }
    uploadFilePart.style.display = 'none';
    canvas.style.display = 'flex';
    confirmationButtons.style.display = 'flex';
});

function drawCanvas(image, imageWidth, imageHeight) {
    var xForCanvas = 0;
    var yForCanvas = 0;
    var newImageWidth = imageWidth;
    var newImageHeight = imageHeight;
    if (imageWidth > imageHeight) {
        newImageWidth = imageHeight
        xForCanvas = (imageWidth - imageHeight) / 2;
    } else {
        newImageHeight = imageWidth
        yForCanvas = (imageHeight - imageWidth) / 2;
    }
    canvas.width = imageWidthDesired;
    canvas.height = imageHeightDesired;
    if (xForCanvas < 0) xForCanvas = 0;
    if (yForCanvas < 0) yForCanvas = 0;
    canvas.getContext('2d').drawImage(image, xForCanvas, yForCanvas, newImageWidth, newImageHeight,
        0, 0, canvas.width, canvas.height);
}

cenaFilter.addEventListener('click', function () {
    if (filtersSelected.includes("Cena/cena")) {
        cenaFilter.style.border = "6.5px #68D2B3 solid";
        const index = filtersSelected.indexOf("Cena/cena");
        if (index >= 0) {
            filtersSelected.splice(index, 1);
            filtersToInput();
        }
    } else {
        filtersSelected.push("Cena/cena");
        filtersToInput();
        cenaFilter.style.border = "6.5px #485FC7 solid";
    }
});

dassinFilter.addEventListener('click', function () {
    if (filtersSelected.includes("Dassin/dassin")) {
        dassinFilter.style.border = "6.5px #68D2B3 solid";
        const index = filtersSelected.indexOf("Dassin/dassin");
        if (index >= 0) {
            filtersSelected.splice(index, 1);
            filtersToInput();
        }
    } else {
        filtersSelected.push("Dassin/dassin");
        filtersToInput();
        dassinFilter.style.border = "6.5px #485FC7 solid";
    }
});

hallidayFilter.addEventListener('click', function () {
    if (filtersSelected.includes("Halliday/halliday")) {
        hallidayFilter.style.border = "6.5px #68D2B3 solid";
        const index = filtersSelected.indexOf("Halliday/halliday");
        if (index >= 0) {
            filtersSelected.splice(index, 1);
            filtersToInput();
        }
    } else {
        filtersSelected.push("Halliday/halliday");
        filtersToInput();
        hallidayFilter.style.border = "6.5px #485FC7 solid";
    }
});

knoxvilleFilter.addEventListener('click', function () {
    if (filtersSelected.includes("Knoxville/knoxville")) {
        knoxvilleFilter.style.border = "6.5px #68D2B3 solid";
        const index = filtersSelected.indexOf("Knoxville/knoxville");
        if (index >= 0) {
            filtersSelected.splice(index, 1);
            filtersToInput();
        }
    } else {
        filtersSelected.push("Knoxville/knoxville");
        filtersToInput();
        knoxvilleFilter.style.border = "6.5px #485FC7 solid";
    }
});

lennonFilter.addEventListener('click', function () {
    if (filtersSelected.includes("Lennon/lennon")) {
        lennonFilter.style.border = "6.5px #68D2B3 solid";
        const index = filtersSelected.indexOf("Lennon/lennon");
        if (index >= 0) {
            filtersSelected.splice(index, 1);
            filtersToInput();
        }
    } else {
        filtersSelected.push("Lennon/lennon");
        filtersToInput();
        lennonFilter.style.border = "6.5px #485FC7 solid";
    }
});

pesciFilter.addEventListener('click', function () {
    if (filtersSelected.includes("Pesci/pesci")) {
        pesciFilter.style.border = "6.5px #68D2B3 solid";
        const index = filtersSelected.indexOf("Pesci/pesci");
        if (index >= 0) {
            filtersSelected.splice(index, 1);
            filtersToInput();
        }
    } else {
        filtersSelected.push("Pesci/pesci");
        filtersToInput();
        pesciFilter.style.border = "6.5px #485FC7 solid";
    }
});

var removeButton = document.querySelectorAll(".removeButton");

removeButton.forEach(function (button) {
    button.addEventListener("submit", function () {
        button.disabled = true;
    });
    button.addEventListener('keypress', function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
        }
    });
});

function filtersToInput() {
    var filtersString = "";
    filtersSelected.forEach((filters) => {
        filtersString += (filters + ';');
    });
    filterSelectInput.value = filtersString;
    if (filtersString.length > 0 && !snapshotDisabled) {
        takeSnapshotButton.disabled = false;
        sendPictureButton.disabled = false;
    } else {
        takeSnapshotButton.disabled = true;
        if (!uploadTypeInput.value)
            sendPictureButton.disabled = true;
    }
}

var fileTypes = ["image/png"];

async function validFileType(file) {
    for (var i = 0; i < fileTypes.length; i++) {
        if (file.type === fileTypes[i]) {
            const ret = await loadMime(file);
            return ret;
        }
    }
    return false;
}

function returnFileSize(number) {
    if (number < 1024) {
        return number + " octets";
    } else if (number >= 1024 && number < 1048576) {
        return (number / 1024).toFixed(1) + " Ko";
    } else if (number >= 1048576) {
        return (number / 1048576).toFixed(1) + " Mo";
    }
}

async function loadMime(file) {
    var mimes = [
        {
            mime: 'image/png',
            pattern: [0x89, 0x50, 0x4E, 0x47],
        }
    ];

    function convertToHex(bytes)
    {
        var arr = [];
        bytes.forEach(function(byte) {
            arr.push('0x' + ('0' + (byte & 0xFF).toString(16).toLocaleUpperCase()).slice(-2));
        });
        return arr;
    }

    function checkTypes(hexBytes)
    {
        for(i = 0; i < 2; i++) {
            if (mimes[i].mime == file.type)
                if (hexBytes.toString() == convertToHex(mimes[i].pattern).toString())
                    return true;
            return false;
        }
    }

    var blob = file.slice(0, 4);

    let hexBytesPromise = new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.addEventListener("loadend", () => {
            var bytes = new Uint8Array(reader.result);
            let hexBytes = convertToHex(bytes);
            resolve(hexBytes);
        });
        reader.readAsArrayBuffer(blob);
    });
    let hexBytes = await hexBytesPromise;

    return checkTypes(hexBytes);
}
