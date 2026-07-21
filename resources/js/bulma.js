function initializeBulmaNavbar() {
    const burgers = document.querySelectorAll(".navbar-burger");

    burgers.forEach((burger) => {
        burger.addEventListener("click", () => {
            const targetId = burger.dataset.target;
            const target = document.getElementById(targetId);

            if (!target) {
                console.warn(
                    `No se encontró el menú de Bulma con ID: ${targetId}`
                );
                return;
            }

            const isActive = burger.classList.toggle("is-active");
            target.classList.toggle("is-active", isActive);
            burger.setAttribute("aria-expanded", String(isActive));
        });
    });
}

function openModal(modal) {
    modal.classList.add("is-active");
    document.documentElement.classList.add("is-clipped");
}

function closeModal(modal) {
    modal.classList.remove("is-active");
    document.documentElement.classList.remove("is-clipped");
}

function initializeBulmaModals() {
    document.querySelectorAll("[data-modal-open]").forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const modalId = trigger.dataset.modalOpen;
            const modal = document.getElementById(modalId);

            if (modal) {
                openModal(modal);
            }
        });
    });

    document.querySelectorAll(".modal").forEach((modal) => {
        modal.querySelectorAll("[data-modal-close]").forEach((trigger) => {
            trigger.addEventListener("click", () => closeModal(modal));
        });
    });

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        document
            .querySelectorAll(".modal.is-active")
            .forEach((modal) => closeModal(modal));
    });
}

document.addEventListener("DOMContentLoaded", () => {
    initializeBulmaNavbar();
    initializeBulmaModals();
});
