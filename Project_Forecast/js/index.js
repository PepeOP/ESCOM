// $(document).ready(function(){
//     $('.sidenav').sidenav();
//   });

import data from "./data.js";

const ITEMS_PER_PAGE = 10;


const url = window.location.href;
const urlParams = new URLSearchParams(new URL(url).search);
const pageQuery = parseInt(urlParams.get('page'));

let page = pageQuery || 1;
let pageCount = Math.ceil(data.length / ITEMS_PER_PAGE);
let offset = (page - 1) * ITEMS_PER_PAGE;

console.log(offset);

console.log(data[0]);


for( let i = offset; i < offset + 10; i++ ) {
    const item = data[i];

    const year = item.dloc.slice(0,4);
    const month = item.dloc.slice(4,6);
    const day = item.dloc.slice(6,8);

    const card = `
    <div class="col s12 m6 l3">
              <div class="card blue-grey darken-1">
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
    `
    const cardElement = document.createElement('div');
    cardElement.innerHTML = card;

    const element = document.getElementById('weather-cards');
    element.append(cardElement);
}


const paginator = document.getElementById('paginator');
const elementPaginator = document.createElement('li');









