var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
function setupRadioContainer(element) {
    let buttons = element.querySelectorAll("[data-radio-button]");
    buttons.forEach((button) => {
        button.addEventListener("click", event => {
            let parent = button.parentElement;
            let isSelected = parent.classList.contains("selected");
            if (isSelected)
                event.preventDefault();
            buttons.forEach((button) => {
                let parent = button.parentElement;
                parent.classList.remove("selected");
                button.checked = false;
            });
            parent.classList.add("selected");
            button.checked = true;
        });
    });
}
function setupRadioButtons() {
    document
        .querySelectorAll("[data-radio-container]")
        .forEach(setupRadioContainer);
}
function getRadioValue(element) {
    let button = Array.from(element.querySelectorAll("[data-radio-button]")).find(button => {
        let parent = button.parentElement;
        return parent.classList.contains("selected");
    });
    if (!button)
        return null;
    return button.value;
}
function getCoordX() {
    return Number(getRadioValue(document.querySelector("#coord-x")));
}
function getCoordY() {
    let input = document.querySelector("#coord-y");
    return parseFloat(input.value);
}
function validateCoordY() {
    let value = getCoordY();
    let isValid = !isNaN(value) && value > -5 && value < 3;
    let message = isValid ? "" : "огонь по своим!!!";
    document.querySelector("#coord-y-error").innerHTML = message;
    return isValid;
}
function getRadius() {
    return parseFloat(getRadioValue(document.querySelector("#radius")));
}
function setupFormSubmit() {
    let form = document.querySelector("form");
    if (!form)
        return;
    form.addEventListener("submit", event => {
        event.preventDefault();
        if (!validateCoordY())
            return;
        send({
            x: getCoordX(),
            y: getCoordY(),
            r: getRadius(),
        });
    });
}
function sendPlane(params) {
    let id = String(Math.floor(Math.random() * 1000));
    let planeProto = document.querySelector("#plane-proto");
    let bombProto = document.querySelector("#bomb-proto");
    let playground = document.querySelector("#playground");
    let plane = planeProto.cloneNode();
    plane.id = "plane" + id;
    let bomb = bombProto.cloneNode();
    bomb.id = "bomb" + id;
    let x = params.x / params.r * 0.6 * 50 + 50;
    let y = (-params.y) / params.r * 0.6 * 50 + 50;
    plane.style.top = y + "%";
    bomb.style.left = x + "%";
    bomb.style.top = y + "%";
    playground.appendChild(plane);
    playground.appendChild(bomb);
    setTimeout(() => {
        bomb.remove();
        plane.remove();
    }, 5000);
}
function send(params) {
    return __awaiter(this, void 0, void 0, function* () {
        sendPlane(params);
        let res = yield fetch("api.php", {
            method: "POST",
            body: JSON.stringify(params)
        });
        let text = yield res.text();
        document
            .querySelector(".result")
            .insertAdjacentHTML("afterbegin", text);
    });
}
window.addEventListener("DOMContentLoaded", () => {
    setupRadioButtons();
    setupFormSubmit();
});

