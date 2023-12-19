
fetch('../json/DailyForecast_MX.json')
      .then(response => response.json())
      .then(data => {
        const ITEMS_PER_PAGE = 100;
        let filteredData = data;
        let page = 1;

        // Obtener nombres únicos de los estados
        const uniqueStates = Array.from(new Set(data.map(item => item.nes)));
        const uniqueDesciels = Array.from(new Set(data.map(item => item.desciel)));
        const uniqueDates = Array.from(new Set(data.map(item => item.dloc)));
        

        // Llenar el select con los nombres de los estados
        const stateFilterSelect = $('#stateFilter');
        uniqueStates.forEach(state => {
          stateFilterSelect.append(`<option value="${state}">${state}</option>`);
        });
        stateFilterSelect.formSelect();

        const DescielsSelect = $('#descielFilter');
        uniqueDesciels.forEach(ciel => {
            DescielsSelect.append(`<option value="${ciel}">${ciel}</option>`);
        });
        DescielsSelect.formSelect();

        const DlocSelect = $('#dateFilter');
        uniqueDates.forEach(fecha => {
            DlocSelect.append(`<option value="${fecha}">${fecha}</option>`);
        });
        DlocSelect.formSelect();

        // Función para actualizar las opciones del select de municipios
        window.updateMunicipalityOptions = function () {
          const selectedState = $('#stateFilter').val();
          const municipalities = Array.from(new Set(data.filter(item => item.nes === selectedState).map(item => item.nmun)));

          // Limpiar y llenar el select de municipios
          const municipalityFilterSelect = $('#municipalityFilter');
          municipalityFilterSelect.empty();
          municipalityFilterSelect.append(`<option disabled selected>Selecciona el municipio</option>`);
          municipalities.forEach(municipality => {
            municipalityFilterSelect.append(`<option value="${municipality}">${municipality}</option>`);
          });
          municipalityFilterSelect.formSelect();
        };

        window.applyFilter = ()=> {
            let selectedState = $('#stateFilter').val();
            let selectedMunicipality = $('#municipalityFilter').val();
            let selectedDesciel = $('#descielFilter').val();
            let selectedDate = $('#dateFilter').val();

            // Filtrar por estado y municipio
            if (selectedState && selectedMunicipality && selectedDesciel && selectedDate) {
              const sql = `SELECT * FROM ? WHERE nes = ? AND nmun = ? AND desciel = ? AND dloc = ?`;
              filteredData = alasql(sql, [data, selectedState, selectedMunicipality, selectedDesciel, selectedDate]);
          
              
              page = 1;
              renderWeatherCards();
                } else if (selectedState && selectedMunicipality && selectedDesciel) {
                  const sql = `SELECT * FROM ? WHERE nes = ? AND nmun = ? AND desciel = ?`;
                  filteredData = alasql(sql, [data, selectedState, selectedMunicipality, selectedDesciel]);
          
              
                  page = 1;
                  renderWeatherCards();
                } else if(selectedState && selectedMunicipality && selectedDate) {
                  const sql = `SELECT * FROM ? WHERE nes = ? AND nmun = ? AND dloc = ?`;
                  filteredData = alasql(sql, [data, selectedState, selectedMunicipality, selectedDate]);
          
              
                  page = 1;
                  renderWeatherCards();
                } else if(selectedState && selectedDesciel && selectedDate) {
                  const sql = `SELECT * FROM ? WHERE nes = ? AND desciel = ? AND dloc = ?`;
                  filteredData = alasql(sql, [data, selectedState, selectedDesciel, selectedDate]);
                  
                  page = 1;
                  renderWeatherCards();
                } else if(selectedState && selectedMunicipality) {
                  const sql = `SELECT * FROM ? WHERE nes = ? AND nmun = ?`;
                  filteredData = alasql(sql, [data, selectedState, selectedMunicipality]);
              
                  
                  page = 1;
                  renderWeatherCards();
                } else if(selectedState && selectedDesciel) {
                  const sql = `SELECT * FROM ? WHERE nes = ? AND desciel = ?`;
                  filteredData = alasql(sql, [data, selectedState, selectedDesciel]);
          
              
                  page = 1;
                  renderWeatherCards();
                } else if(selectedState && selectedDate) {
                  const sql = `SELECT * FROM ? WHERE nes = ? AND dloc = ?`;
                  filteredData = alasql(sql, [data, selectedState, selectedDate]);
          
              
                  page = 1;
                  renderWeatherCards();
                } else if(selectedDesciel && selectedDate) {
                  const sql = `SELECT * FROM ? WHERE desciel = ? AND dloc = ?`;
                  filteredData = alasql(sql, [data, selectedDesciel, selectedDate]);
          
              
                  page = 1;
                  renderWeatherCards();
                } else if(selectedDesciel) {
                  const sql = `SELECT * FROM ? WHERE desciel = ?`;
                  filteredData = alasql(sql, [data, selectedDesciel]);
              
                  
                  page = 1;
                  renderWeatherCards();
                } else if(selectedDate) {
                  const sql = `SELECT * FROM ? WHERE dloc = ?`;
                  filteredData = alasql(sql, [data, selectedDate]);
              
                  
                  page = 1;
                  renderWeatherCards();
                } else  if (selectedState) {
                        // Filtrar solo por estado
                        const sql = `SELECT * FROM ? WHERE nes = ?`;
                        filteredData = alasql(sql, [data, selectedState]);
                    
                       
                        page = 1;
                        renderWeatherCards();
                      } else {
              
              filteredData = data;
              page = 1;
              renderWeatherCards();
                 }
             
          }

        function renderWeatherCards() {
          const element = document.getElementById('weather-cards');
          element.innerHTML = ''; // Limpiar el contenedor antes de renderizar

          const offset = (page - 1) * ITEMS_PER_PAGE;

          for (let i = offset; i < offset + ITEMS_PER_PAGE && i < filteredData.length; i++) {
            const item = filteredData[i];

            const year = item.dloc.slice(0, 4);
            const month = item.dloc.slice(4, 6);
            const day = item.dloc.slice(6, 8);

            const card = `
              <div class="col s12 m6 l4">
                <div class="card light-blue darken-1 card large" id="">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="" src="./images/batman1.jpg">
                </div>
                  <div class="card-content grey-darken-2-text">
                    <span class="card-title"><strong>  ${item.nes} </strong></span>
                    
                  </div>
                  <div class="card-action" id="card">
                  <h5>${item.nmun} </h5>
                  <p><strong>${item.desciel}</strong></p>
                  <p><strong>${year}/${month}/${day}</strong></p>
                    <p><strong>Temp. Max:</strong> ${item.tmax} <strong>Temp. Min:</strong> ${item.tmin}</p>
                  <p><strong>%P:</strong> ${item.probprec}</p>
                  </div>
                </div>
              </div>
            `;

            const cardElement = document.createElement('div');
            cardElement.innerHTML = card;
            element.append(cardElement);
          }

          renderPaginator();
        }

        function renderPaginator() {
          const paginator = document.getElementById('paginator');
          paginator.innerHTML = ''; // Limpiar el paginador antes de renderizar

          const pageCount = Math.ceil(filteredData.length / ITEMS_PER_PAGE);

          // Mostrar flecha "anterior"
          if (page != 1) {
            const prevLink = createPageLink(page - 1, false, 'chevron_left');
            paginator.appendChild(prevLink);
          }

          // Mostrar enlaces de páginas
          for (let i = page - 5; i <= page + 5; i++) {
            if (i > pageCount) break;
            if ([-4, -3, -2, -1, 0].includes(i)) continue;
            paginator.appendChild(createPageLink(i, i === page));
        }

          // Mostrar flecha "siguiente"
          if (page != pageCount) {
            const nextLink = createPageLink(page + 1, false, 'chevron_right');
            paginator.appendChild(nextLink);
          }
        }

        // Función para manejar el cambio de página
        function handlePageChange(newPage) {
          page = newPage;
          renderWeatherCards();
        }

        function createPageLink(pageNumber, isActive, icon) {
          const li = document.createElement('li');
          const a = document.createElement('a');
          a.href = `javascript:void(0);`; // Hacer el enlace no clickeable por ahora

          if (icon) {
            a.innerHTML = `<i class="material-icons">${icon}</i>`;
          } else {
            a.textContent = pageNumber;
          }

          if (isActive) {
            li.classList.add('active');
            li.classList.add('blue');
          } else {
            li.classList.add('waves-effect');
            a.addEventListener('click', () => handlePageChange(pageNumber));
          }

          li.appendChild(a);
          return li;
        }

        // Inicialmente, mostrar las tarjetas con todos los datos
        renderWeatherCards();
      });

    $(document).ready(()=> {
            $('.sidenav').sidenav();
            $('select').formSelect();
          });

      
      









