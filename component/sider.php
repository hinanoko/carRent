<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../style/sider.css">
</head>

<body>
    <div>
        <p>Search the Item you want: </p>

        <div class="search_member_container">
            <div class="search_container_start">
                <div class="search_icon_container">
                    <img class="search_icon" src="../icons/search.png" alt="Search Icon">
                </div>

                <div class="search_input_container">
                    <input class="search_input" id="searchInput" placeholder="search item" type="text">
                </div>

                <div class="search_submit_btn_container">
                    <div class="search_btn" id="searchBtn">Search</div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <br>
    </div>
    <div class="sidebar">
        <div class="sidebar-header"></div>
        <ul>
            <li class="mainButton">Browser Category</li>
            <div class="submenu">
                <ul>
                    <li class="expandable">Honda</li>
                    <div class="secondSubmenu">
                        <ul>
                            <li class="secondExpandable" data-info="cars_info_1">Sedan</li>
                            <li class="secondExpandable" data-info="cars_info_2">Suv</li>
                            <li class="secondExpandable" data-info="cars_info_3">Wagon</li>
                        </ul>
                    </div>
                    <li class="expandable">Nissan</li>
                    <div class="secondSubmenu">
                        <ul>
                            <li class="secondExpandable" data-info="cars_info_4">Sedan</li>
                            <li class="secondExpandable" data-info="cars_info_5">Suv</li>
                            <li class="secondExpandable" data-info="cars_info_6">Wagon</li>
                        </ul>
                    </div>
                    <li class="expandable">Toyota</li>
                    <div class="secondSubmenu">
                        <ul>
                            <li class="secondExpandable" data-info="cars_info_7">Sedan</li>
                            <li class="secondExpandable" data-info="cars_info_8">Suv</li>
                            <li class="secondExpandable" data-info="cars_info_9">Wagon</li>
                        </ul>
                    </div>
                </ul>
            </div>
        </ul>
    </div>

    <div id="carInfoContainer"></div>

    <script>
        var recentSearches = JSON.parse(sessionStorage.getItem('recentSearches')) || []; // Initialize an empty array

        // Wait for the DOM content to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            var suggestionsContainer;
            var mainButton = document.querySelector('.mainButton');
            var sidebar = document.querySelector('.sidebar');
            var submenu = mainButton.nextElementSibling;

            // Toggle the sidebar and submenu visibility on main button click
            mainButton.addEventListener('click', function() {
                submenu.classList.toggle('open');
                sidebar.classList.toggle('open');
            });

            // Handle click events on expandable elements
            var expandables = document.querySelectorAll('.expandable');
            expandables.forEach(function(expandable) {
                expandable.addEventListener('click', function() {
                    var submenu = this.nextElementSibling;
                    if (submenu.classList.contains('open')) {
                        submenu.classList.remove('open');
                    } else {
                        closeAllSubmenus(submenu);
                        submenu.classList.add('open');
                    }
                });
            });

            // Handle click events on second expandable elements
            var secondExpandables = document.querySelectorAll('.secondExpandable');
            secondExpandables.forEach(function(secondExpandable) {
                secondExpandable.addEventListener('click', function() {
                    var submenu = this.nextElementSibling;
                    if (submenu.classList.contains('open')) {
                        submenu.classList.remove('open');
                    } else {
                        closeAllThirdSubmenus(submenu);
                        submenu.classList.add('open');
                    }
                });
            });

            // Function to close main menus except the specified one
            function closeMainMenus(exceptThis) {
                var submenus = document.querySelectorAll('.submenu');
                submenus.forEach(function(submenu) {
                    if (submenu !== exceptThis) {
                        submenu.classList.remove('open');
                    }
                });
            }

            // Function to close all submenus except the specified one
            function closeAllSubmenus(exceptThis) {
                var submenus = document.querySelectorAll('.secondSubmenu');
                submenus.forEach(function(submenu) {
                    if (submenu !== exceptThis) {
                        submenu.classList.remove('open');
                    }
                });
            }

            // Handle click events on submenu items
            var submenuItems = document.querySelectorAll('.secondSubmenu li');
            submenuItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    var info = this.getAttribute('data-info');
                    console.log("Clicked on submenu with text: " + info);
                    sidebar.classList.remove('open');
                    closeMainMenus();
                    closeAllSubmenus();

                    var params = new URLSearchParams();
                    params.append('info', info);
                    parent.document.getElementById("mainPanel").src = "../component/main.php?" + params.toString();
                });
            });

            // Event listener for search functionality
            var searchInput = document.getElementById('searchInput');
            var searchBtn = document.getElementById('searchBtn');
            var recentSearchesContainer;

            // Event listener for search button click
            searchBtn.addEventListener('click', function() {
                var searchInputValue = searchInput.value.trim();
                if (searchInputValue !== '') {
                    updateRecentSearches(searchInputValue);
                }

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../controller/search_car.php", true);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            displaySearchResults(response);
                        } else {
                            console.error("Error:", xhr.statusText);
                        }
                    }
                };
                xhr.send(JSON.stringify({
                    query: searchInputValue
                }));
            });

            // Function to display recent searches when the search input is focused
            searchInput.addEventListener('focus', function() {
                displayRecentSearches();
            });

            // Function to display recent searches based on input value
            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() === '') {
                    displayRecentSearches();
                } else {
                    if (recentSearchesContainer) {
                        recentSearchesContainer.style.display = 'none';
                    }
                }
            });

            // Function to hide recent searches container on blur
            searchInput.addEventListener('blur', function() {
                setTimeout(function() { // Delay to allow click event on recent searches
                    if (recentSearchesContainer) {
                        recentSearchesContainer.style.display = 'none';
                    }
                }, 200);
            });

            // Function to display recent searches container
            function displayRecentSearches() {
                if (recentSearchesContainer) {
                    recentSearchesContainer.remove();
                }

                recentSearchesContainer = document.createElement('div');
                recentSearchesContainer.classList.add('recent-searches');

                var recentSearchesHeader = document.createElement('div');
                recentSearchesHeader.classList.add('recent-searches-header');
                recentSearchesHeader.textContent = 'Recent Searches';
                recentSearchesContainer.appendChild(recentSearchesHeader);

                if (recentSearches.length > 0) {
                    var recentSearchesList = document.createElement('ul');
                    recentSearches.forEach(function(keyword) {
                        var listItem = document.createElement('li');
                        listItem.textContent = keyword;
                        listItem.addEventListener('click', function() {
                            searchInput.value = keyword;
                            recentSearchesContainer.remove();
                        });
                        recentSearchesList.appendChild(listItem);
                    });
                    recentSearchesContainer.appendChild(recentSearchesList);
                } else {
                    var noRecentSearches = document.createElement('div');
                    noRecentSearches.textContent = 'No recent searches';
                    recentSearchesContainer.appendChild(noRecentSearches);
                }

                document.body.appendChild(recentSearchesContainer);
                positionRecentSearchesContainer();
            }

            // Function to position the recent searches container
            function positionRecentSearchesContainer() {
                var searchInputRect = searchInput.getBoundingClientRect();
                recentSearchesContainer.style.left = searchInputRect.left + 'px';
                recentSearchesContainer.style.top = (searchInputRect.bottom + window.scrollY - 1) + 'px'; // Adjusted to be closer
            }

            // Function to update recent searches array
            function updateRecentSearches(searchInputValue) {
                if (!recentSearches.includes(searchInputValue)) {
                    recentSearches.push(searchInputValue);
                    if (recentSearches.length > 5) {
                        recentSearches.shift();
                    }
                    // Save recent searches to session storage
                    sessionStorage.setItem('recentSearches', JSON.stringify(recentSearches));
                }
            }

            // Function to display search results
            function displaySearchResults(results) {
                var params = new URLSearchParams();
                params.append('results', JSON.stringify(results));
                parent.document.getElementById("mainPanel").src = "../component/searchMain.php?" + params.toString();
            }

            // Event listener for input changes in search input
            searchInput.addEventListener('input', function() {
                var query = searchInput.value.trim();
                if (query.length > 0) {
                    fetchSuggestions(query);
                } else {
                    if (suggestionsContainer) {

                        suggestionsContainer.style.display = 'none';
                    }
                }
            });

            // Function to fetch search suggestions from the server
            function fetchSuggestions(query) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../controller/fetch_suggestions.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        var suggestions = JSON.parse(xhr.responseText);
                        displaySuggestions(suggestions);
                    }
                };
                xhr.send(JSON.stringify({
                    query: query
                }));
            }

            var searchInputContainer = document.querySelector('.search_input_container');
            var suggestionsContainer;

            // Fetch Suggestions Function and Display Suggestions Function remain the same

            function displaySuggestions(suggestions) {
                if (!suggestionsContainer) {
                    suggestionsContainer = document.createElement('div');
                    suggestionsContainer.classList.add('suggestions');
                    document.body.appendChild(suggestionsContainer); // Append the container to the body
                }

                suggestionsContainer.innerHTML = '';
                if (suggestions.length > 0) {
                    var ul = document.createElement('ul');
                    suggestions.forEach(function(suggestion) {
                        var li = document.createElement('li');
                        li.textContent = suggestion;
                        li.addEventListener('click', function() {
                            searchInput.value = suggestion;
                            suggestionsContainer.style.display = 'none';
                        });
                        ul.appendChild(li);
                    });
                    suggestionsContainer.appendChild(ul);
                    suggestionsContainer.style.display = 'block';

                    // Calculate the position of the search suggestions container
                    var searchInputRect = searchInput.getBoundingClientRect();
                    suggestionsContainer.style.left = searchInputRect.left + 'px';
                    suggestionsContainer.style.top = (searchInputRect.bottom + window.scrollY) + 'px';
                } else {
                    suggestionsContainer.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>