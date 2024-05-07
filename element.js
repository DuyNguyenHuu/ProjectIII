function openTab(evt, tab, isright) {
  var i, tabLink, tabContent;
  tabContent = document.getElementsByClassName("tabContent");
  for (i = 0; i < tabContent.length; i++) {
    if (isright == true) {
      if (tabContent[i].className == "tabContent") {
        tabContent[i].style.display = "none";
      }
    } else if (tabContent[i].className !== "tabContent") {
      tabContent[i].style.display = "none";
    }
  }
  tabLink = document.getElementsByClassName("tabLink");
  for (i = 0; i < tabLink.length; i++) {
    if (isright == true) {
      if (tabLink[i].parentNodeclassName == "list") {
        tabLink[i].className = tabLink[i].className.replace(" active", "");
      }
    } else {
      if (tabLink[i].parentNode.className != "list") {
        tabLink[i].className = tabLink[i].className.replace(" active", "");
      }
    }
  }
  document.getElementById(tab).style.display = "block";
  evt.currentTarget.className += " active";
}
function display(id) {
  document.getElementById(id).click();
  console.log(id);
}
