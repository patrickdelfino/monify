const allLinks = document.querySelectorAll(".stcode-tabs a");
const allTabs = document.querySelectorAll(".stcode-tab-content");
const tabContentWrapper = document.querySelector(".stcode-tab-content-wrapper");

const shiftTabs = (linkId) => {
    allTabs.forEach((tab, i) => {
        if (tab.id.includes(linkId)) {
            allTabs.forEach((tabItem) => {
                tabItem.style = `transform: translateY(-${i * 500}px);`;
            });
        }
    });
};

allLinks.forEach((elem) => {
    elem.addEventListener("click", function (event) {
        // Impedir o comportamento padrão do link
        event.preventDefault();

        const linkId = elem.id;

        allLinks.forEach((link, i) => {
            if (link === elem) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });

        shiftTabs(linkId);
    });
});

//? handle proper selection for initial load
const currentHash = window.location.hash;

let activeLink = document.querySelector(`.stcode-tabs a`);

if (currentHash) {
    const visibleHash = document.getElementById(
        `${currentHash.replace("#", "")}`
    );

    if (visibleHash) {
        activeLink = visibleHash;
    }
}

// Verifique se activeLink não é nulo antes de acessar suas propriedades
if (activeLink) {
    activeLink.classList.add("active");
    shiftTabs(activeLink.id);
}

const seoTitleInput = document.getElementById('seo_title');
const seoDescTextarea = document.getElementById('seo_description');
const seoTitleCount = document.getElementById('sseo_title_count');
const seoDescCount = document.getElementById('sseo_desc_count');

// Função para contar caracteres
function countCharacters(input, counter, maxChars) {
    input.addEventListener('input', function() {
        const count = input.value.length;
        counter.innerText = count;

        // Adapte a lógica conforme necessário para diferentes contagens máximas
        if (count > maxChars) {
            counter.style.color = 'red'; // ou outra indicação de que excedeu
        } else {
            counter.style.color = ''; // redefina a cor
        }
    });
}

// Contagem para o título com máximo de 60 caracteres
countCharacters(seoTitleInput, seoTitleCount, 60);

// Contagem para a descrição com máximo de 160 caracteres
countCharacters(seoDescTextarea, seoDescCount, 160);

const resultTitle = document.querySelector('.stcode-result-title');
const resultDescription = document.querySelector('.stcode-result-description');

// Função para atualizar o preview
function updatePreview() {
    resultTitle.innerText = seoTitleInput.value || 'Example Result Title';
    resultDescription.innerText = seoDescTextarea.value || 'Example Result Description';
}

// Adiciona ouvintes de evento aos campos de entrada
seoTitleInput.addEventListener('input', updatePreview);
seoDescTextarea.addEventListener('input', updatePreview);