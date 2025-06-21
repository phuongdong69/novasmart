var pageName = window.location.pathname.split("/").pop().split(".")[0];

var fixedPlugin = document.querySelector("[fixed-plugin]");
var fixedPluginButton = document.querySelector("[fixed-plugin-button]");
var fixedPluginButtonNav = document.querySelector("[fixed-plugin-button-nav]");
var fixedPluginCard = document.querySelector("[fixed-plugin-card]");
var fixedPluginCloseButton = document.querySelector("[fixed-plugin-close-button]");

var navbar = document.querySelector("[navbar-main]");
var buttonNavbarFixed = document.querySelector("[navbarFixed]");
var sidenav = document.querySelector("aside");
var sidenav_icons = sidenav ? sidenav.querySelectorAll("li a div") : [];

var sidenav_target = "../pages/" + pageName + ".html";

var whiteBtn = document.querySelector("[transparent-style-btn]");
var darkBtn = document.querySelector("[white-style-btn]");

var non_active_style = ["bg-none", "bg-transparent", "text-blue-500", "border-blue-500"];
var active_style = ["bg-gradient-to-tl", "from-blue-500", "to-violet-500", "bg-blue-500", "text-white", "border-transparent"];

var white_sidenav_classes = ["bg-white", "shadow-xl"];
var black_sidenav_classes = ["bg-slate-850", "shadow-none"];

var sidenav_highlight = document.querySelector("a[href=" + CSS.escape(sidenav_target) + "]");

// === Fixed plugin toggle ===

if (fixedPluginButton && fixedPluginCard && fixedPluginCloseButton && fixedPluginButtonNav) {
  if (pageName != "rtl") {
    fixedPluginButton.addEventListener("click", function () {
      fixedPluginCard.classList.toggle("-right-90");
      fixedPluginCard.classList.toggle("right-0");
    });

    fixedPluginButtonNav.addEventListener("click", function () {
      fixedPluginCard.classList.toggle("-right-90");
      fixedPluginCard.classList.toggle("right-0");
    });

    fixedPluginCloseButton.addEventListener("click", function () {
      fixedPluginCard.classList.toggle("-right-90");
      fixedPluginCard.classList.toggle("right-0");
    });

    window.addEventListener("click", function (e) {
      if (
        !fixedPlugin.contains(e.target) &&
        !fixedPluginButton.contains(e.target) &&
        !fixedPluginButtonNav.contains(e.target)
      ) {
        if (fixedPluginCard.classList.contains("right-0")) {
          fixedPluginCloseButton.click();
        }
      }
    });
  } else {
    fixedPluginButton.addEventListener("click", function () {
      fixedPluginCard.classList.toggle("-left-90");
      fixedPluginCard.classList.toggle("left-0");
    });

    fixedPluginButtonNav.addEventListener("click", function () {
      fixedPluginCard.classList.toggle("-left-90");
      fixedPluginCard.classList.toggle("left-0");
    });

    fixedPluginCloseButton.addEventListener("click", function () {
      fixedPluginCard.classList.toggle("-left-90");
      fixedPluginCard.classList.toggle("left-0");
    });

    window.addEventListener("click", function (e) {
      if (
        !fixedPlugin.contains(e.target) &&
        !fixedPluginButton.contains(e.target) &&
        !fixedPluginButtonNav.contains(e.target)
      ) {
        if (fixedPluginCard.classList.contains("left-0")) {
          fixedPluginCloseButton.click();
        }
      }
    });
  }
}

// === Sidebar color ===

function sidebarColor(a) {
  var color = a.getAttribute("data-color");
  var parent = a.parentElement.children;
  var activeColor;
  var activeSidenavIconColorClass;
  var checkedSidenavIconColor = "bg-" + color + "-500/30";
  var sidenavIcon = document.querySelector("a[href=" + CSS.escape(sidenav_target) + "]");

  for (var i = 0; i < parent.length; i++) {
    if (parent[i].hasAttribute("active-color")) {
      activeColor = parent[i].getAttribute("data-color");

      parent[i].classList.toggle("border-white");
      parent[i].classList.toggle("border-slate-700");

      activeSidenavIconColorClass = "bg-" + activeColor + "-500/30";
    }
    parent[i].removeAttribute("active-color");
  }

  var att = document.createAttribute("active-color");

  a.setAttributeNode(att);
  a.classList.toggle("border-white");
  a.classList.toggle("border-slate-700");

  if (sidenavIcon) {
    sidenavIcon.classList.remove(activeSidenavIconColorClass);
    sidenavIcon.classList.add(checkedSidenavIconColor);
  }
}

// === Sidenav style toggle ===

if (whiteBtn && darkBtn && sidenav) {
  whiteBtn.addEventListener("click", function () {
    const active_style_attr = document.createAttribute("active-style");
    if (!this.hasAttribute("active-style")) {
      this.setAttributeNode(active_style_attr);
      non_active_style.forEach((cls) => this.classList.remove(cls));
      active_style.forEach((cls) => this.classList.add(cls));

      darkBtn.removeAttribute("active-style");
      active_style.forEach((cls) => darkBtn.classList.remove(cls));
      non_active_style.forEach((cls) => darkBtn.classList.add(cls));

      black_sidenav_classes.forEach((cls) => sidenav.classList.remove(cls));
      white_sidenav_classes.forEach((cls) => sidenav.classList.add(cls));
      sidenav.classList.remove("dark");
    }
  });

  darkBtn.addEventListener("click", function () {
    const active_style_attr = document.createAttribute("active-style");
    if (!this.hasAttribute("active-style")) {
      this.setAttributeNode(active_style_attr);
      non_active_style.forEach((cls) => this.classList.remove(cls));
      active_style.forEach((cls) => this.classList.add(cls));

      whiteBtn.removeAttribute("active-style");
      active_style.forEach((cls) => whiteBtn.classList.remove(cls));
      non_active_style.forEach((cls) => whiteBtn.classList.add(cls));

      white_sidenav_classes.forEach((cls) => sidenav.classList.remove(cls));
      black_sidenav_classes.forEach((cls) => sidenav.classList.add(cls));
      sidenav.classList.add("dark");
    }
  });
}

// === Navbar Fixed ===

if (navbar) {
  if (navbar.getAttribute("navbar-scroll") == "true" && buttonNavbarFixed) {
    buttonNavbarFixed.setAttribute("checked", "true");
  }

  const white_elements = navbar.querySelectorAll(".text-white");
  const white_bg_elements = navbar.querySelectorAll("[sidenav-trigger] i.bg-white");
  const white_before_elements = navbar.querySelectorAll(".before\\:text-white");

  if (buttonNavbarFixed) {
    buttonNavbarFixed.addEventListener("change", function () {
      if (this.checked) {
        white_elements.forEach(el => {
          el.classList.remove("text-white");
          el.classList.add("dark:text-white");
        });
        white_bg_elements.forEach(el => {
          el.classList.remove("bg-white");
          el.classList.add("dark:bg-white", "bg-slate-500");
        });
        white_before_elements.forEach(el => {
          el.classList.add("dark:before:text-white");
          el.classList.remove("before:text-white");
        });

        navbar.setAttribute("navbar-scroll", "true");
        navbar.classList.add("sticky", "top-[1%]", "backdrop-saturate-200", "backdrop-blur-2xl", "dark:bg-slate-850/80", "dark:shadow-dark-blur", "bg-[hsla(0,0%,100%,0.8)]", "shadow-blur", "z-110");
      } else {
        navbar.setAttribute("navbar-scroll", "false");
        navbar.classList.remove("sticky", "top-[1%]", "backdrop-saturate-200", "backdrop-blur-2xl", "dark:bg-slate-850/80", "dark:shadow-dark-blur", "bg-[hsla(0,0%,100%,0.8)]", "shadow-blur", "z-110");
        white_elements.forEach(el => {
          el.classList.add("text-white");
          el.classList.remove("dark:text-white");
        });
        white_bg_elements.forEach(el => {
          el.classList.add("bg-white");
          el.classList.remove("dark:bg-white", "bg-slate-500");
        });
        white_before_elements.forEach(el => {
          el.classList.remove("dark:before:text-white");
          el.classList.add("before:text-white");
        });
      }
    });
  }
} else if (buttonNavbarFixed) {
  buttonNavbarFixed.setAttribute("disabled", "true");
}

// === Dark mode toggle ===

var dark_mode_toggle = document.querySelector("[dark-toggle]");
var root_html = document.querySelector("html");

if (dark_mode_toggle && root_html) {
  dark_mode_toggle.addEventListener("change", function () {
    dark_mode_toggle.setAttribute("manual", "true");
    if (this.checked) {
      root_html.classList.add("dark");
    } else {
      root_html.classList.remove("dark");
    }
  });
}
