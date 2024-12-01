function fetchSuggestions() {
    const input = document.getElementById("property-search").value;
    const suggestionsBox = document.getElementById("suggestions");
  
    suggestionsBox.innerHTML = ""; // Clear previous suggestions
  
    if (input) {
      fetch(`search.php?q=${encodeURIComponent(input)}`)
        .then(response => response.json())
        .then(data => {
          data.forEach(item => {
            const suggestion = document.createElement("div");
            suggestion.textContent = item.name;
            suggestion.onclick = () => redirectToPage(item.detail_page); // Use detail_page
            suggestionsBox.appendChild(suggestion);
          });
        })
        .catch(error => console.error("Error fetching suggestions:", error));
    }
  }
  
  // Redirect to the specific detail page
  function redirectToPage(detailPage) {
    window.location.href = detailPage;
  }
  