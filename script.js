const poemList = document.getElementById("poem-list");
const modal = document.getElementById("poem-modal");
const modalTitle = document.getElementById("modal-title");
const modalCategory = document.getElementById("modal-category");
const modalPoem = document.getElementById("modal-poem");
const closeModal = document.getElementById("close-modal");
const menuToggle = document.getElementById("menu-toggle");
const nav = document.getElementById("nav");

if (!poemList) {
    console.warn("Poem list container not found on the page.");
}

async function loadPublishedPoems() {

    if (!poemList) {
        return;
    }

    try {

        const response = await fetch("api/poem.php");

        if (!response.ok) {
            throw new Error("Could not load poems.");
        }

        const poems = await response.json();

        displayPoems(poems);

    } catch (error) {

        console.error(error);

        poemList.innerHTML = `
            <div class="poem-card">
                <p class="poem-category">
                    GEN-ESIS THE POET
                </p>

                <h3>
                    Poetry Archive
                </h3>

                <p>
                    The poetry collection is currently
                    being updated. Please check again soon.
                </p>
            </div>
        `;

    }
}

function displayPoems(poems) {

    poemList.innerHTML = "";

    if (!Array.isArray(poems) || poems.length === 0) {

        poemList.innerHTML = `
            <div class="poem-card">
                <p class="poem-category">
                    THE ARCHIVE
                </p>

                <h3>
                    No Published Poems Yet
                </h3>

                <p>
                    New poetry will appear here when
                    GEN-ESIS publishes it.
                </p>
            </div>
        `;

        return;
    }

    poems.forEach((poem, index) => {

        const article = document.createElement("article");

        article.className = "poem-card";

        const preview =
            poem.content.length > 150
                ? poem.content.substring(0, 150) + "..."
                : poem.content;

        article.innerHTML = `
            <div class="poem-number">
                ${String(index + 1).padStart(2, "0")}
            </div>

            <p class="poem-category">
                ${escapeHTML(poem.category)}
            </p>

            <h3>
                ${escapeHTML(poem.title)}
            </h3>

            <p>
                ${escapeHTML(preview)}
            </p>

            <button class="read-poem">
                READ POEM
            </button>
        `;

        const button = article.querySelector(".read-poem");

        button.addEventListener("click", function () {
            openPoem(poem);
        });

        poemList.appendChild(article);

    });
}

function openPoem(poem) {

    modalTitle.textContent = poem.title;
    modalCategory.textContent = poem.category;
    modalPoem.textContent = poem.content;

    modal.classList.add("active");

    document.body.style.overflow = "hidden";
}

function closePoem() {

    modal.classList.remove("active");

    document.body.style.overflow = "";
}

if (closeModal) {
    closeModal.addEventListener("click", closePoem);
}

if (modal) {
    modal.addEventListener("click", function (event) {

        if (event.target === modal) {
            closePoem();
        }

    });
}

document.addEventListener("keydown", function (event) {

    if (event.key === "Escape" && modal) {
        closePoem();
    }

});

if (menuToggle && nav) {
    menuToggle.addEventListener("click", function () {

        nav.classList.toggle("active");

    });
}

document.querySelectorAll(".nav a").forEach(function (link) {

    link.addEventListener("click", function () {
        if (nav) {
            nav.classList.remove("active");
        }
    });

});

function escapeHTML(text) {

    const element = document.createElement("div");

    element.textContent = text;

    return element.innerHTML;
}

const yearElement = document.getElementById("year");

if (yearElement) {
    yearElement.textContent = new Date().getFullYear();
}

loadPublishedPoems();