// Selecting the sidebar and buttons
const sidebar = document.querySelector(".sidebar");
const col1HiddeBar = document.querySelector('.columna1');
const col2ShowBar = document.querySelector('.columna2');
// const sidebarOpenBtn = document.querySelector("#sidebar-open");
const sidebarCloseBtn = document.querySelector("#sidebar-close");
const sidebarLockBtn = document.querySelector("#lock-icon");

// Function to toggle the lock state of the sidebar
const toggleLock = () => {
  sidebar.classList.toggle("locked");
  // If the sidebar is not locked
  if (!sidebar.classList.contains("locked")) {
    sidebar.classList.add("hoverable");
    sidebarLockBtn.classList.replace("bx-lock-alt", "bx-lock-open-alt");
  } else {
    sidebar.classList.remove("hoverable");
    sidebarLockBtn.classList.replace("bx-lock-open-alt", "bx-lock-alt");
  }
};

// Function to hide the sidebar when the mouse leaves
const hideSidebar = () => {
  if (sidebar.classList.contains("hoverable")){
    sidebar.classList.add("close");
    if (sidebar.classList.contains("close")){
      col1HiddeBar.classList.remove('col-2'); 
      col1HiddeBar.classList.add('col-1');
    } else {
      col1HiddeBar.classList.remove('col-1');
      col1HiddeBar.classList.add('col-2');
    }
  }
};

// Function to show the sidebar when the mouse enter
const showSidebar = () => {
  if (sidebar.classList.contains("hoverable")) {
    sidebar.classList.remove("close");
    if(col2ShowBar.classList.contains('col-11')){
      col2ShowBar.classList.remove('col-11');
    } else {
      col2ShowBar.classList.remove('col-10');
    }
    col1HiddeBar.classList.remove('col-2');
    col2ShowBar.classList.add('col-10');
    col1HiddeBar.classList.add('col-2');
  }
};

// Function to show and hide the sidebar
const toggleSidebar = () => {
  sidebar.classList.toggle("close");
};

// If the window width is less than 800px, close the sidebar and remove hoverability and lock
if (window.innerWidth < 800) {
  sidebar.classList.add("close");
  sidebar.classList.remove("locked");
  sidebar.classList.remove("hoverable");
}

// Adding event listeners to buttons and sidebar for the corresponding actions
sidebarLockBtn.addEventListener("click", toggleLock);
sidebar.addEventListener("mouseleave", hideSidebar);
sidebar.addEventListener("mouseenter", showSidebar);
// sidebarOpenBtn.addEventListener("click", toggleSidebar);
sidebarCloseBtn.addEventListener("click", toggleSidebar);
