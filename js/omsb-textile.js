function textileParser( name ) {

  // Get the value of the textarea
  var textile = document.getElementById(name).value;

  // Create a new XMLHttpRequest object
  var xhttp = new XMLHttpRequest();

  // Set the callback function
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // Parse the response as JSON
      var response = JSON.parse(this.responseText);

      // Check if the request was successful
      if (response.success) {
        // Update the page with the formatted HTML
        document.querySelector('[data-source="' + name + '"]').innerHTML = response.html;
      } else {
        // Show an error message
        alert("An error occurred while parsing the textile input.");
      }
    }
  };

  // Open the request
  xhttp.open("POST", "/ajax-textile.php", true);

  // Set the request header
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Send the request
  xhttp.send("textile=" + encodeURIComponent(textile));
}

// Credit: https://codepen.io/hollyw00d/pen/JjYJWjG
function tabs() {
  var accessibleTabsContainers = document.querySelectorAll('.accessible-tabs-container');
  var tabSelector = document.querySelectorAll('.tab-selectors > li');
  var tabContent = document.querySelectorAll('.tab-contents > div');
  var largeRandNumber = Math.floor((Math.random() * 1000) + 1000);

  accessibleTabsContainers.forEach(function(elem, indexAccessibleTabContainer) {
    elem.setAttribute('data-id', indexAccessibleTabContainer);

    tabSelector.forEach(function(singleTabSelector, i) {

      var tabSelectorId = 'tab-selector-' + largeRandNumber + '_' + i + '_' + indexAccessibleTabContainer;
      var tabContentId = 'tab-content-' + largeRandNumber + '_' + i + '_' + indexAccessibleTabContainer;

      singleTabSelector.setAttribute('data-id', i);
      singleTabSelector.setAttribute('id', tabSelectorId);
      singleTabSelector.setAttribute('aria-controls', tabContentId);

      tabContent[i].setAttribute('data-id', i);
      tabContent[i].setAttribute('tabindex', 0);
      tabContent[i].setAttribute('role', 'tabpanel');
      tabContent[i].setAttribute('id', tabContentId);
      tabContent[i].setAttribute('aria-labeledby', tabSelectorId);

      if(i === 0) {
        singleTabSelector.setAttribute('aria-pressed', 'true');
      } else {
        singleTabSelector.setAttribute('aria-pressed', 'false');
        singleTabSelector.setAttribute('tabindex', -1);
      }
    });
  });


  function onTabSelectorClick(e) {
      var tabSelectorSelected = e.target;
      var accessibleTabsContainerSelected = tabSelectorSelected.closest('.accessible-tabs-container');
      var tabSelectorsSelectedFromTabs = accessibleTabsContainerSelected.querySelectorAll('ul > li');
      var tabContentsSelectedFromContainer = accessibleTabsContainerSelected.querySelectorAll('.tab-contents > div');

      if(!tabSelectorSelected.classList.contains('active-tab-selector')) {
        tabSelectorsSelectedFromTabs.forEach(function(singleTabSelected, i) {
          if ( ! tabContentsSelectedFromContainer[i] ) {
            return;
          }
          var tabId = tabContentsSelectedFromContainer[i].getAttribute('data-id');
          if(tabSelectorSelected.getAttribute('data-id') === tabId ) {
            singleTabSelected.classList.add('active-tab-selector');
            singleTabSelected.setAttribute('tabindex', 0);
            singleTabSelected.setAttribute('aria-pressed', 'true');
            tabContentsSelectedFromContainer[i].classList.add('tab-content-active');
          } else {
            singleTabSelected.classList.remove('active-tab-selector');
            singleTabSelected.setAttribute('tabindex', -1);
            singleTabSelected.setAttribute('aria-pressed', 'false');
            tabContentsSelectedFromContainer[i].classList.remove('tab-content-active');
          }

        });
      }

  }

  tabSelector.forEach(function(tabSelector) {
    tabSelector.addEventListener('click', onTabSelectorClick);
  });
}

tabs();
