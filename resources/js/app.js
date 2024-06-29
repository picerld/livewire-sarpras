// import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

// // start
// // dark theme
// const darkToggle = document.querySelector("#dark-toggle");
// const html = document.querySelector("html");

// darkToggle?.addEventListener("click", function () {
//   if (darkToggle.checked) {
//     html.classList.add("dark");
//     localStorage.theme = "dark";
//   } else {
//     html.classList.remove("dark");
//     localStorage.theme = "light";
//   }
// });

// // condition toggle jika dark mode
// if (
//   localStorage.theme === "dark" ||
//   (!("theme" in localStorage) &&
//     window.matchMedia("(prefers-color-scheme: dark)").matches)
// ) {
//   darkToggle.checked = true;
// } else {
//   darkToggle.checked = false;
// }

// // sidebar menu dropdown
// document.addEventListener("DOMContentLoaded", function () {
//   const sidebar = document.querySelectorAll(".sidebar");

//   sidebar.forEach(function (toggle) {
//     toggle.addEventListener("click", function () {
//       const sidebarOpen = toggle.querySelector(".sidebarOpen");

//       sidebarOpen.classList.toggle("hidden");
//     });
//   });
// });

// // close click sidebar menu
// const sidebarToggle = document.querySelector("#sidebar-toggle");
// const drawerToggle = document.querySelector(".drawer-toggle");
// const sidebar = document.querySelector("#sidebar");

// drawerToggle?.addEventListener("click", () => {
//   if (drawerToggle.checked) {
//     sidebar.classList.remove("hidden");

//     sidebarToggle.addEventListener("click", () => {
//       drawerToggle.checked = false;
//     });
//   } else {
//     sidebar.classList.add("hidden");
//   }
// });

// // click di luar "x"
// window.addEventListener("click", function (e) {
//   if (
//     e.target != sidebar &&
//     e.target != sidebarToggle &&
//     e.target != drawerToggle
//   ) {
//     sidebar?.classList.remove("hidden");
//   }
// });

// // export button
// const exportButton = document.querySelector("#menu-button");
// const menu = document.querySelector("#menu-drop");

// exportButton?.addEventListener("click", () => {
//   menu.classList.toggle("hidden");
// });


// // function seartable
// function searchTable() {
//   var input = document.getElementById("searchInput");
//   var filter = input.value.toUpperCase();

//   var table = document.getElementById("myTable");
//   var rows = table.getElementsByTagName("tr");

//   for (var i = 0; i < rows.length; i++) {
//     var cells = rows[i].getElementsByTagName("td");
//     var found = false;

//     for (var j = 0; j < cells.length; j++) {
//       var cell = cells[j];
//       if (cell) {
//         if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
//           found = true;
//           break;
//         }
//       }
//     }

//     if (found || i === 0) {
//       rows[i].style.display = "";
//     } else {
//       rows[i].style.display = "none";
//     }
//   }
// }


// // user navbar
// window.onscroll = function () {
//   const header = document.querySelector("header")
//   const fixedNav = header?.offsetTop

//   window.pageYOffset > fixedNav ? header?.classList.add("nav-fixed") : header?.classList.remove("nav-fixed")

//   header?.classList.add('nav-fixed')
  
// };

// // modal
// document.querySelector('#next-button')?.addEventListener('click', function() {
//   document.querySelector('#tambah_permintaan').close();
//   document.querySelector('#qty_modal').showModal();
// });

// document.querySelector('#next-button-qty')?.addEventListener('click', function() {
//   document.querySelector('#qty_modal').close();
//   document.querySelector('#confirm_modal').showModal();
// });

// document.querySelector('#back-button-qty')?.addEventListener('click', function() {
//   document.querySelector('#qty_modal').close();
//   document.querySelector('#tambah_permintaan').showModal();
// });

// document.querySelector('#back-button-confirm')?.addEventListener('click', function() {
//   document.querySelector('#confirm_modal').close();
//   document.querySelector('#qty_modal').showModal();
// });

// document.querySelector('#next-button-confirm')?.addEventListener('click', function() {
//   document.querySelector('#confirm_modal').close();
//   document.querySelector('#transaction_modal').showModal();
// });

// // faq section
// document.querySelectorAll('.accordion-toggle').forEach(button => {
//   button.addEventListener('click', () => {
//     const accordionContent = button.nextElementSibling;

//     button.classList.toggle('accordion-active');

//     if (button.classList.contains('accordion-active')) {
//       accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
//     } else {
//       accordionContent.style.maxHeight = 0;
//     }
//   });
// });

// // select filter
// const filter = document.getElementById('categorySelect')?.addEventListener('change', function() {
//   const selectedCategory = this.value;
//   const rows = document.querySelectorAll('#myTable tbody tr');
  
//   rows.forEach(row => {
//     const rowCategory = row.getAttribute('data-category');
//     if (selectedCategory === 'default' || selectedCategory === rowCategory) {
//       row.style.display = '';
//     } else {
//       row.style.display = 'none';
//     }
//   });
//   console.log(selectedCategory);
// });