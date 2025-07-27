// Function to set content of textarea when submitting
function setContent() {
    const content = document.getElementById('textarea');
    const input = document.getElementById('content');

    input.textContent = content.innerHTML;
}

// Function to convert textarea to HTML code
const showCode = document.getElementById('show-code');
let active = false;

showCode.addEventListener('click', function (event) {
    const content = document.getElementById('textarea');
    showCode.dataset.active = !active;
    active = !active;

    if (active) {
        // Convert content to code (text)
        content.textContent = content.innerHTML;

    } else {
        // Convert code back to HTML content
        try {
            content.innerHTML = content.textContent;
        } catch (error) {
            console.error("Error converting text to HTML: ", error);
        }
    }
});

document.getElementById('textarea').addEventListener('paste', function (e) {
    e.preventDefault();

    var text = (e.clipboardData || window.clipboardData).getData('text/plain');

    var formattedText = text.replace(/\n/g, '<br>');

    this.innerHTML += formattedText;
});

// Function to format text
function formatText(cmd, value = null) {
    if (value) {
        document.execCommand(cmd, false, value);
    } else {
        document.execCommand(cmd);
    }
}

// Function to show tab of upload image
function showTab(id) {
    var i;
    var x = document.getElementsByClassName("tab-content");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(id).style.display = "flex";
}

// Event handler for clicking upload image
document.querySelectorAll(".upload").forEach(function (uploadImg) {
    uploadImg.addEventListener("click", function () {
        const inputFile = uploadImg.querySelector('input[type="file"]');
        inputFile.click();
    });
});

// Function to show uploaded image names
let uploadedFiles = {
    imgExterior: [],
    imgInterior: [],
    imgMechanical: [],
    imgDocs: [],
    imgOther: []
};

function showListImages(event, id, number) {
    var files = event.target.files;

    if (number !== null) {
        if (files.length + uploadedFiles[id].length > 10) {
            alert("Maximum 10 images can be uploaded.");
            return;
        } else if (files.length + uploadedFiles[id].length < number) {
            alert("Minimum "+number+" images are required.");
            return;
        }

        for (const file of files) {
            uploadedFiles[id].push(file);
        }
    } else {
        if (files.length + uploadedFiles[id].length > 10) {
            alert("Maximum 10 images can be uploaded.");
            return;
        }
        for (const file of files) {
            uploadedFiles[id].push(file);
        }
    }

    getFileList(id);
}

// Function to get list of uploaded images
function getFileList(id) {
    var listImage = document.getElementById(id);
    listImage.innerHTML = "";

    uploadedFiles[id].forEach((file, index) => {
        const li = document.createElement("li");

        const a = document.createElement("a");
        a.textContent = file.name;
        a.style.cursor = "pointer";
        a.href = URL.createObjectURL(file);
        a.target = "_blank";

        const remove = document.createElement("a");
        remove.textContent = "Delete";
        remove.style.marginLeft = "10px";
        remove.onclick = function () {
            removeFile(id, index);
        };

        li.appendChild(a);
        li.appendChild(remove);
        listImage.appendChild(li);
    });
}

// Function to remove file from the list
function removeFile(id, index) {
    uploadedFiles[id].splice(index, 1);
    getFileList(id);
}

// Event handler for form suggestion
document.addEventListener("DOMContentLoaded", function () {
    fetch("car.json")
        .then(response => response.json())
        .then(data => {
            const makeInput = document.getElementById("makeInput");
            const modelInput = document.getElementById("modelInput");
            const makeDropdown = document.getElementById("makeDropdown");
            const modelDropdown = document.getElementById("modelDropdown");

            function filterAndDisplayDropdown(inputElement, dropdownElement, items) {
                const query = inputElement.value.toLowerCase();
                dropdownElement.innerHTML = ""; // Clear old items
                dropdownElement.style.display = "none"; // Hide dropdown if no items

                const filteredItems = items.filter(item => item.toLowerCase().includes(query));
                filteredItems.forEach(item => {
                    const itemElement = document.createElement("div");
                    itemElement.classList.add("dropdown-item");
                    itemElement.textContent = item;
                    itemElement.addEventListener("click", function () {
                        inputElement.value = item; // Set value when selected
                        dropdownElement.style.display = "none"; // Hide dropdown after selection
                    });
                    dropdownElement.appendChild(itemElement);
                });

                // Show dropdown if there are items
                if (filteredItems.length > 0) {
                    dropdownElement.style.display = "block";
                }
            }

            // When user types in makeInput
            makeInput.addEventListener("input", function () {
                filterAndDisplayDropdown(makeInput, makeDropdown, data.car[0].make);
            });

            // When user types in modelInput
            modelInput.addEventListener("input", function () {
                filterAndDisplayDropdown(modelInput, modelDropdown, data.car[0].model);
            });

            // Hide dropdowns when clicking outside
            document.addEventListener("click", function (e) {
                if (!modelInput.contains(e.target) && !modelDropdown.contains(e.target)) {
                    modelDropdown.style.display = "none";
                }
                if (!makeInput.contains(e.target) && !makeDropdown.contains(e.target)) {
                    makeDropdown.style.display = "none";
                }
            });
        })
        .catch(error => console.error("Error loading JSON:", error));
});

new AutoNumeric('#price', {
    digitGroupSeparator: ',',
    decimalCharacter: '.',
    decimalPlaces: 0,
    minimumValue: '0',
    maximumValue: '999999999',
    currencySymbol: '',
    unformatOnSubmit: true
});

new AutoNumeric('#mileage', {
    digitGroupSeparator: ',',
    decimalCharacter: '.',
    decimalPlaces: 0,
    minimumValue: '0',
    maximumValue: '999999999',
    currencySymbol: '',
    unformatOnSubmit: true
});