function setupRadioContainer(element: HTMLElement) {
    let buttons = element.querySelectorAll("[data-radio-button]");
    buttons.forEach((button: HTMLInputElement) => {
        button.addEventListener("click", event => {
            let parent = button.parentElement;

            let isSelected = parent.classList.contains("selected");
            if (isSelected) event.preventDefault();

            buttons.forEach((button: HTMLInputElement) => {
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

function getRadioValue(element: HTMLElement): string | null {
    let button = Array.from(element.querySelectorAll("[data-radio-button]")).find(button => {
        let parent = button.parentElement;
        return parent.classList.contains("selected");
    });
    if (!button) return null;
    return (button as HTMLInputElement).value;
}

function getCoordX(): number {
    return parseFloat(getRadioValue(document.querySelector("#coord-x")));
}

function getCoordY(): number {
    let input = document.querySelector("#coord-y");
    return parseFloat((input as HTMLInputElement).value);
}

function validateCoordY() {
    let value = getCoordY();
    let isValid = !isNaN(value) && value > -5 && value < 3;
    
    let message = isValid ? "" : "огонь по своим!!!";
    document.querySelector("#coord-y-error").innerHTML = message;
    
    return isValid;
}

function getRadius(): number {
    return parseFloat(getRadioValue(document.querySelector("#radius")));
}

function setupFormSubmit() {
    let form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", event => {
        event.preventDefault();

        if (!validateCoordY()) return;
        
        send({
            x: getCoordX(),
            y: getCoordY(),
            r: getRadius(),
        });
    });
}

function sendPlane(params: { x: number; y: number; r: number}) {
    let id = String(Math.floor(Math.random() * 1000));

    let planeProto = document.querySelector("#plane-proto");
    let bombProto = document.querySelector("#bomb-proto");
    let playground = document.querySelector("#playground");
    
    let plane = planeProto.cloneNode() as HTMLElement;
    plane.id = "plane" + id;

    let bomb = bombProto.cloneNode() as HTMLElement;
    bomb.id = "bomb" + id;
    
    let x = params.x / params.r * 0.6 * 50 + 50;
    let y = params.y / params.r * 0.6 * 50 + 50;

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

async function send(params: { x: number; y: number; r: number}) {
    sendPlane(params);
    
    let res = await fetch("api.php", {
        method: "POST",
        body: JSON.stringify(params)
    });
    
    let text = await res.text();
    document
        .querySelector(".result")
        .insertAdjacentHTML("afterbegin", text);
}

window.addEventListener("DOMContentLoaded", () => {
    setupRadioButtons();
    setupFormSubmit();
});
