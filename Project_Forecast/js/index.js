fetch('../json/DailyForecast_MX.json')
    .then(response => response.json()) // Parsea la respuesta JSON
    .then(data => {
      const ITEMS_PER_PAGE = 100;

      const url = window.location.href;
      const urlParams = new URLSearchParams(new URL(url).search);
      const pageQuery = parseInt(urlParams.get('page'));
      
      let page = pageQuery || 1;
      let pageCount = Math.ceil(data.length / ITEMS_PER_PAGE);
      let offset = (page - 1) * ITEMS_PER_PAGE;
      
      console.log(offset);
      
      console.log(data[0]);
      
      for (let i = offset; i < offset + ITEMS_PER_PAGE && i < data.length; i++) {
          const item = data[i];
      
          const year = item.dloc.slice(0, 4);
          const month = item.dloc.slice(4, 6);
          const day = item.dloc.slice(6, 8);
      
          const card = `
          <div class="col s12 m6 l3">
              <div class="card blue-grey darken-1 card small">
                  <div class="card-content white-text">
                      <span class="card-title">${year}/${month}/${day} ${item.desciel} ${item.nes} / ${item.nmun}</span>
                      <p>${item.tmax}</p>
                      <p>${item.tmax}</p>
                  </div>
                  <div class="card-action">
                      <p>${item.tmax}</p>
                      <p>${item.tmax}</p>
                  </div>
              </div>
          </div>
          `;
      
          const cardElement = document.createElement('div');
          cardElement.innerHTML = card;
      
          const element = document.getElementById('weather-cards');
          element.append(cardElement);
      }
      
    const paginator = document.getElementById('paginator');
    paginator.classList.add('pagination', 'center-align'); // Añade clases de Materialize

    const createPageLink = (pageNumber, isActive) => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = `?page=${pageNumber}`;
        a.textContent = pageNumber;

        if (isActive) {
            li.classList.add('active');
        } else {
          li.classList.add('waves-effect')
        }

        li.appendChild(a);
        return li;
    };

    // Mostrar enlace "anterior"
    if(page != 1) {
        const prevLink = createPageLink(page - 1, false);
        paginator.appendChild(prevLink);
    }


    // Mostrar enlaces de páginas
    for (let i = page - 5; i <= page + 5; i++) {
        if(i > pageCount) break;
        if([-4,-3,-2,-1,0].includes(i)) continue;
        paginator.appendChild(createPageLink(i, i === page));
    }


        console.log(pageCount, "pagecount")
    if( page != pageCount) {
        // Mostrar enlace "siguiente"
        const nextLink = createPageLink(page + 1, false);
        paginator.appendChild(nextLink);
    }

        window.addEventListener('scroll', () => {
            let scrollPosition = window.scrollY; // Posición vertical del scrollbar
            console.log("Posición del Scroll: " + scrollPosition);

        });


    
  
  });

    $(document).ready(()=> {
            $('.sidenav').sidenav();
          });

      
      









