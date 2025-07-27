function showTab(id) {
    var i;
    var x = document.getElementsByClassName("tab-content");
    for (i = 0; i < x.length; i++) {
        x[i].className = "tab-content";
    }
    document.getElementById(id).className = "tab-content active";
}

const tabs = document.querySelectorAll(".tab-btn");
tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
        tabs.forEach((tab) => tab.classList.remove("active"));

        this.classList.add("active");
    });
});

// Function to set content of textarea when submitting
function setContent() {
    const content = document.getElementById("textarea");
    const input = document.getElementById("content");

    input.textContent = content.innerHTML;
}

// Function to convert textarea to HTML code
const showCode = document.getElementById("show-code");
let active = false;

showCode.addEventListener("click", function (event) {
    const content = document.getElementById("textarea");
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

document.getElementById("textarea").addEventListener("paste", function (e) {
    e.preventDefault();

    var text = (e.clipboardData || window.clipboardData).getData("text/plain");

    var formattedText = text.replace(/\n/g, "<br>");

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

new AutoNumeric("#price", {
    digitGroupSeparator: ",",
    decimalCharacter: ".",
    decimalPlaces: 0,
    minimumValue: "0",
    maximumValue: "999999999",
    currencySymbol: "",
    unformatOnSubmit: true,
});

new AutoNumeric("#mileage", {
    digitGroupSeparator: ",",
    decimalCharacter: ".",
    decimalPlaces: 0,
    minimumValue: "0",
    maximumValue: "999999999",
    currencySymbol: "",
    unformatOnSubmit: true,
});





