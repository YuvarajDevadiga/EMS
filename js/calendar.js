

// document.addEventListener('DOMContentLoaded', function () {
//     let calendar;
//     let isEmployee;
//     let role = $("#calbody").data("role");
//     isEmployee = (role === 'employee');

//     // Enhanced cache implementation with localStorage support
//     const CalendarCache = {
//         // In-memory cache
//         memoryCache: {
//             rawData: {},
//             filteredData: {},
//             currentMonth: null,
//             currentYear: null
//         },

//         // Constants
//         CACHE_VERSION: '1.0',
//         CACHE_EXPIRY: 24 * 60 * 60 * 1000, // 24 hours in milliseconds
//         MAX_CACHE_SIZE: 50000, // Maximum number of tasks to store

//         // Initialize cache
//         init() {
//             this.loadFromLocalStorage();
//             this.cleanExpiredCache();
//         },

//         // Store data in both memory and localStorage
//         setData(month, year, data) {
//             const key = `${year}-${month}`;

//             // Update memory cache
//             this.memoryCache.rawData[key] = data;

//             // Update localStorage with timestamp
//             const cacheEntry = {
//                 version: this.CACHE_VERSION,
//                 timestamp: Date.now(),
//                 data: data
//             };

//             try {
//                 localStorage.setItem(`calendarCache_${key}`, JSON.stringify(cacheEntry));
//             } catch (e) {
//                 console.warn('localStorage quota exceeded, clearing old entries');
//                 this.clearOldestEntries();
//             }
//         },

//         // Get data from cache
//         getData(month, year) {
//             const key = `${year}-${month}`;

//             // Check memory cache first
//             if (this.memoryCache.rawData[key]) {
//                 return this.memoryCache.rawData[key];
//             }

//             // Check localStorage
//             const cached = localStorage.getItem(`calendarCache_${key}`);
//             if (cached) {
//                 const cacheEntry = JSON.parse(cached);

//                 // Verify cache version and expiry
//                 if (cacheEntry.version === this.CACHE_VERSION &&
//                     Date.now() - cacheEntry.timestamp < this.CACHE_EXPIRY) {
//                     // Update memory cache
//                     this.memoryCache.rawData[key] = cacheEntry.data;
//                     return cacheEntry.data;
//                 }
//             }

//             return null;
//         },

//         // Load initial data from localStorage
//         loadFromLocalStorage() {
//             Object.keys(localStorage)
//                 .filter(key => key.startsWith('calendarCache_'))
//                 .forEach(key => {
//                     try {
//                         const cacheEntry = JSON.parse(localStorage.getItem(key));
//                         if (cacheEntry.version === this.CACHE_VERSION) {
//                             const [year, month] = key.replace('calendarCache_', '').split('-');
//                             this.memoryCache.rawData[`${year}-${month}`] = cacheEntry.data;
//                         }
//                     } catch (e) {
//                         console.warn('Invalid cache entry:', key);
//                     }
//                 });
//         },

//         // Clean expired cache entries
//         cleanExpiredCache() {
//             const now = Date.now();
//             Object.keys(localStorage)
//                 .filter(key => key.startsWith('calendarCache_'))
//                 .forEach(key => {
//                     try {
//                         const cacheEntry = JSON.parse(localStorage.getItem(key));
//                         if (now - cacheEntry.timestamp > this.CACHE_EXPIRY) {
//                             localStorage.removeItem(key);
//                         }
//                     } catch (e) {
//                         localStorage.removeItem(key);
//                     }
//                 });
//         },

//         // Clear oldest entries when storage is full
//         clearOldestEntries() {
//             const cacheEntries = Object.keys(localStorage)
//                 .filter(key => key.startsWith('calendarCache_'))
//                 .map(key => ({
//                     key,
//                     timestamp: JSON.parse(localStorage.getItem(key)).timestamp
//                 }))
//                 .sort((a, b) => a.timestamp - b.timestamp);

//             // Remove oldest 25% of entries
//             const entriesToRemove = Math.ceil(cacheEntries.length * 0.25);
//             cacheEntries.slice(0, entriesToRemove).forEach(entry => {
//                 localStorage.removeItem(entry.key);
//             });
//         },

//         // Check if data needs refresh
//         needsRefresh(month, year) {
//             const cached = this.getData(month, year);
//             return !cached || Date.now() - cached.timestamp > this.CACHE_EXPIRY;
//         }
//     };

//     // Initialize filters
//     function initializeFilters() {
//         if (!isEmployee) {
//             $.ajax({
//                 url: "../core/fetch_users.php",
//                 method: 'GET',
//                 dataType: "json",
//                 success: function (response) {
//                     if (response) {
//                         const $userSelect = $('#userFilter');
//                         $userSelect.empty().append('<option value="">Select User</option>');
//                         response.forEach(user => {
//                             $userSelect.append($('<option>', {
//                                 value: user.id,
//                                 text: user.name
//                             }));
//                         });
//                     }
//                 }
//             });
//         }

//         $.ajax({
//             url: "../core/fetch_categories.php",
//             method: 'GET',
//             dataType: "json",
//             success: function (response) {
//                 if (response) {
//                     const $categorySelect = $('#categoryFilter');
//                     $categorySelect.empty().append('<option value="">Select Category</option>');
//                     response.forEach(category => {
//                         $categorySelect.append($('<option>', {
//                             value: category.id,
//                             text: category.name
//                         }));
//                     });
//                 }
//             }
//         });

//         $('#categoryFilter, #userFilter').on('change', function () {
//             applyFilters();
//         });
//     }

//     // Apply filters to calendar events
//     function applyFilters() {
//         const categoryFilter = $('#categoryFilter').val();
//         const userFilter = isEmployee ? '' : $('#userFilter').val();
//         const currentMonthKey = `${CalendarCache.memoryCache.currentYear}-${CalendarCache.memoryCache.currentMonth}`;

//         if (CalendarCache.memoryCache.rawData[currentMonthKey]) {
//             const filteredEvents = filterEvents(CalendarCache.memoryCache.rawData[currentMonthKey], categoryFilter, userFilter);
//             calendar.removeAllEvents();
//             calendar.addEventSource(filteredEvents);
//         }
//     }

//     // Filter events based on category and user
//     function filterEvents(events, categoryId, userId) {
//         return events.filter(event => {
//             let matchesCategory = true;
//             let matchesUser = true;

//             if (categoryId) {
//                 matchesCategory = event.extendedProps.category_id === parseInt(categoryId);
//             }

//             if (userId && !isEmployee) {
//                 matchesUser = event.extendedProps.user_id === parseInt(userId);
//             }

//             return matchesCategory && matchesUser;
//         });
//     }

//     // Load month data with caching
//     function loadMonthData(month, year, callback) {
//         const cachedData = CalendarCache.getData(month, year);

//         if (cachedData) {
//             console.log('Using cached data for', month, year);
//             const filteredEvents = filterEvents(
//                 cachedData,
//                 $('#categoryFilter').val(),
//                 isEmployee ? '' : $('#userFilter').val()
//             );
//             if (callback) callback(filteredEvents);
//             return;
//         }

//         console.log('Fetching fresh data for', month, year);
//         const endpoint = isEmployee ? "../core/getUserTaskForCal.php" : "../core/fetchTaskForCal.php";

//         $.ajax({
//             url: endpoint,
//             method: 'GET',
//             dataType: 'json',
//             data: {
//                 view: 'calendar',
//                 month: month,
//                 year: year
//             },
//             success: function (response) {
//                 if (response.status === 'success') {
//                     const events = response.tasks.map(task => ({
//                         id: task.id,
//                         title: task.title,
//                         start: task.due_time && task.due_time !== '00:00:00'
//                             ? `${task.due_date}T${task.due_time}`
//                             : task.due_date,
//                         allDay: !task.due_time || task.due_time === '00:00:00',
//                         backgroundColor: getStatusColor(task.status),
//                         extendedProps: {
//                             description: task.description,
//                             category: task.category || task.category_name,
//                             category_id: task.category_id,
//                             status: task.status,
//                             user_id: task.assigned_to,
//                             assignedTo: task.username,
//                             status_name: task.status_name,
//                             due_time: task.due_time
//                         }
//                     }));

//                     // Store in cache
//                     CalendarCache.setData(month, year, events);

//                     const filteredEvents = filterEvents(
//                         events,
//                         $('#categoryFilter').val(),
//                         isEmployee ? '' : $('#userFilter').val()
//                     );

//                     if (callback) callback(filteredEvents);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error loading month data:', error);
//                 if (callback) callback([]);
//             }
//         });
//     }

//     function initializePopoverHeaderClick() {
//         document.addEventListener('click', function (e) {
//             // Check if clicked element is a popover header
//             if (e.target.closest('.fc-popover-title')) {
//                 const popover = e.target.closest('.fc-popover');
//                 if (popover) {
//                     // Extract the date from the header text
//                     const headerText = popover.querySelector(' .fc-popover-title').textContent;
//                     const date = new Date(headerText);

//                     // Only proceed if we got a valid date
//                     if (!isNaN(date.getTime())) {
//                         // Change to day view for the clicked date
//                         calendar.changeView('timeGridDay', date);

//                         // Close the popover
//                         const closeBtn = popover.querySelector('.fc-popover-close');
//                         if (closeBtn) {
//                             closeBtn.click();
//                         }
//                     }
//                 }
//             }
//         });
//     }

//     // Initialize calendar with new event limiting features
//     function initializeCalendar() {
//         const calendarEl = document.getElementById('calendar');

//         // Add CSS for fixed event height in day view
//         const styleElement = document.createElement('style');
//         styleElement.textContent = `
//             /* Fixed height for events in day view */
//             .fc .fc-timegrid-event {
//                 height: 50px !important;
//                 max-height: 50px !important;
//                 overflow: hidden;
//             }

//             /* Better styling for day view events */
//             .fc-timegrid-event .fc-event-main {
//                 padding: 2px 4px !important;
//             }

//             .fc-timegrid-event .fc-event-title {
//                 font-size: 1em;
//                 white-space: nowrap;
//                 overflow: hidden;
//                 text-overflow: ellipsis;
//             }
//         `;
//         document.head.appendChild(styleElement);

//         calendar = new FullCalendar.Calendar(calendarEl, {
//             initialView: 'dayGridMonth',
//             headerToolbar: {
//                 left: 'prev,next today',
//                 center: 'title',
//                 right: 'dayGridMonth,timeGridWeek,timeGridDay'
//             },
//             dayMaxEvents: 2, // Limit number of events shown per day
//             moreLinkContent: function (args) {
//                 return `+${args.num} more`; // Customize the "more" link text
//             },
//             moreLinkClick: function (info) {
//                 info.jsEvent.preventDefault();
//                 // showDayEventsModal(info.date, info.allSegs);
//             },
//             slotMinTime: '00:00:00',
//             slotMaxTime: '24:00:00',
//             displayEventTime: false,
//             eventTimeFormat: {
//                 hour: 'numeric',
//                 minute: '2-digit',
//                 meridiem: 'short'
//             },
//             datesSet: function (info) {
//                 const newMonth = info.view.currentStart.getMonth() + 1;
//                 const newYear = info.view.currentStart.getFullYear();

//                 // Only reload if month/year actually changed
//                 if (newMonth !== CalendarCache.memoryCache.currentMonth ||
//                     newYear !== CalendarCache.memoryCache.currentYear) {
//                     CalendarCache.memoryCache.currentMonth = newMonth;
//                     CalendarCache.memoryCache.currentYear = newYear;
//                     $('#categoryFilter, #userFilter').val('');

//                     // Load data for the new month
//                     loadMonthData(newMonth, newYear, function (events) {
//                         calendar.removeAllEvents();
//                         calendar.addEventSource(events);
//                     });
//                 }
//             },
//             dateClick: function (info) {
//                 calendar.changeView('timeGridDay', info.dateStr);
//             },
//             eventClick: function (info) {
//                 info.jsEvent.preventDefault();
//                 displayEventDetails(info.event);
//             },
//             loading: function (isLoading) {
//                 if (isLoading) {
//                     $('#loadingIndicator').show();
//                 } else {
//                     $('#loadingIndicator').hide();
//                 }
//             },
//             eventDidMount: function (info) {
//                 if (info.view.type === 'dayGridMonth') {
//                     info.el.style.backgroundColor = info.event.backgroundColor;
//                     const eventElements = info.el.querySelectorAll('.fc-event-title, .fc-event-time');
//                     eventElements.forEach(el => {
//                         el.style.color = 'white';
//                         el.style.fontWeight = "light";
//                     });
//                 } else if (info.view.type === 'timeGridDay' || info.view.type === 'timeGridWeek') {
//                     // Enforce fixed height for day/week view events and add styling
//                     info.el.style.backgroundColor = info.event.backgroundColor;
//                     info.el.style.height = '40px';
//                     info.el.style.maxHeight = '40px';
//                     info.el.style.overflow = 'hidden';

//                     // Make text white and add ellipsis for overflow
//                     const eventTitle = info.el.querySelector('.fc-event-title');
//                     if (eventTitle) {
//                         eventTitle.style.color = 'white';
//                         eventTitle.style.whiteSpace = 'nowrap';
//                         eventTitle.style.overflow = 'hidden';
//                         eventTitle.style.textOverflow = 'ellipsis';
//                     }

//                     // Add tooltip with full title and description
//                     const tooltipContent = `
//                         <strong>${info.event.title}</strong><br>
//                         ${info.event.extendedProps.description || 'No description'}<br>
//                         Status: ${info.event.extendedProps.status_name}
//                     `;

//                     // Use Bootstrap tooltip if available, otherwise use title attribute
//                     if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
//                         info.el.setAttribute('data-bs-toggle', 'tooltip');
//                         info.el.setAttribute('data-bs-html', 'true');
//                         info.el.setAttribute('data-bs-title', tooltipContent);
//                         new bootstrap.Tooltip(info.el);
//                     } else {
//                         info.el.setAttribute('title', info.event.title);
//                     }
//                 }
//             }
//         });

//         calendar.render();
//         initializePopoverHeaderClick();
//         // Load initial month's data
//         const initialDate = calendar.getDate();
//         CalendarCache.memoryCache.currentMonth = initialDate.getMonth() + 1;
//         CalendarCache.memoryCache.currentYear = initialDate.getFullYear();

//         loadMonthData(
//             CalendarCache.memoryCache.currentMonth,
//             CalendarCache.memoryCache.currentYear,
//             function (events) {
//                 calendar.removeAllEvents();
//                 calendar.addEventSource(events);
//             }
//         );

//         // Add loading indicator
//         $('body').append(`
//             <div id="loadingIndicator" style="display:none; position:fixed; top:50%; left:50%; 
//                 transform:translate(-50%,-50%); background:rgba(255,255,255,0.8); 
//                 padding:20px; border-radius:5px; z-index:9999;">
//                 Loading tasks...
//             </div>
//         `);
//     }

//     // New function to show all events for a specific day
//     function showDayEventsModal(date, events) {
//         const formattedDate = new Date(date).toLocaleDateString('en-US', {
//             weekday: 'long',
//             year: 'numeric',
//             month: 'long',
//             day: 'numeric'
//         });

//         document.querySelector('#taskDetailsModal .modal-title').textContent = `Tasks for ${formattedDate}`;

//         const tasksList = document.getElementById('dayTasksList');
//         tasksList.innerHTML = '';

//         // Get all events for this day
//         events.forEach(eventSeg => {
//             const event = eventSeg.event;
//             const detailsRow = document.createElement('tr');
//             detailsRow.innerHTML = `
//                 <td><strong>${event.title}</strong></td>
//                 <td>${event.extendedProps.description || 'No description available'}</td>
//                 <td>${event.extendedProps.category}</td>
//                 ${isEmployee ? "" : `<td>${event.extendedProps.assignedTo}</td>`}
//                 <td>
//                     <span class="badge" style="background-color: ${event.backgroundColor}">
//                         ${event.extendedProps.status_name}
//                     </span>
//                 </td>
//             `;
//             tasksList.appendChild(detailsRow);
//         });

//         // Add scrollable style to modal body
//         const modalBody = document.querySelector('#taskDetailsModal .modal-body');
//         modalBody.style.maxHeight = '70vh';
//         modalBody.style.overflowY = 'auto';

//         const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
//         modal.show();
//     }

//     // Display event details in modal
//     function displayEventDetails(event) {
//         document.querySelector('#taskDetailsModal .modal-title').textContent = event.title;

//         const tasksList = document.getElementById('dayTasksList');
//         tasksList.innerHTML = '';

//         const detailsRow = document.createElement('tr');
//         detailsRow.innerHTML = `
//             <td><strong>${event.title}</strong></td>
//             <td>${event.extendedProps.description || 'No description available'}</td>
//             <td>${event.extendedProps.category}</td>
//             ${isEmployee ? "" : `<td>${event.extendedProps.assignedTo}</td>`}
//             <td>
//                 <span class="badge" style="background-color: ${event.backgroundColor}">
//                     ${event.extendedProps.status_name}
//                 </span>
//             </td>
//         `;
//         tasksList.appendChild(detailsRow);

//         // Add scrollable style
//         const modalBody = document.querySelector('#taskDetailsModal .modal-body');
//         modalBody.style.maxHeight = '70vh';
//         modalBody.style.overflowY = 'auto';

//         const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
//         modal.show();
//     }

//     function getStatusColor(status) {
//         const colors = {
//             1: '#6c757d', // New - Grey
//             2: '#17a2b8', // Started - Info
//             3: '#ffc107', // On Hold - Warning
//             4: '#28a745'  // Completed - Success
//         };
//         return colors[status] || '#6c757d';
//     }

//     // Cache monitoring utility
//     function getCacheSize() {
//         return Object.keys(localStorage)
//             .filter(key => key.startsWith('calendarCache_'))
//             .reduce((size, key) => size + localStorage.getItem(key).length, 0);
//     }

//     // Cache invalidation utility
//     function invalidateCache(month, year) {
//         const key = `${year}-${month}`;
//         localStorage.removeItem(`calendarCache_${key}`);
//         delete CalendarCache.memoryCache.rawData[key];
//     }

//     // Initialize the application
//     CalendarCache.init();
//     initializeFilters();
//     initializeCalendar();
// });










































document.addEventListener('DOMContentLoaded', function () {
    let calendar;
    let isEmployee;
    let role = $("#calbody").data("role");
    isEmployee = (role === 'employee');

    // Enhanced cache implementation with localStorage support
    const CalendarCache = {
        // In-memory cache
        memoryCache: {
            rawData: {},
            filteredData: {},
            currentMonth: null,
            currentYear: null
        },

        // Constants
        CACHE_VERSION: '1.0',
        CACHE_EXPIRY: 24 * 60 * 60 * 1000, // 24 hours in milliseconds
        MAX_CACHE_SIZE: 50000, // Maximum number of tasks to store

        // Initialize cache
        init() {
            this.loadFromLocalStorage();
            this.cleanExpiredCache();
        },

        // Store data in both memory and localStorage
        setData(month, year, data) {
            const key = `${year}-${month}`;

            // Update memory cache
            this.memoryCache.rawData[key] = data;

            // Update localStorage with timestamp
            const cacheEntry = {
                version: this.CACHE_VERSION,
                timestamp: Date.now(),
                data: data
            };

            try {
                localStorage.setItem(`calendarCache_${key}`, JSON.stringify(cacheEntry));
            } catch (e) {
                console.warn('localStorage quota exceeded, clearing old entries');
                this.clearOldestEntries();
            }
        },

        // Get data from cache
        getData(month, year) {
            const key = `${year}-${month}`;

            // Check memory cache first
            if (this.memoryCache.rawData[key]) {
                return this.memoryCache.rawData[key];
            }

            // Check localStorage
            const cached = localStorage.getItem(`calendarCache_${key}`);
            if (cached) {
                const cacheEntry = JSON.parse(cached);

                // Verify cache version and expiry
                if (cacheEntry.version === this.CACHE_VERSION &&
                    Date.now() - cacheEntry.timestamp < this.CACHE_EXPIRY) {
                    // Update memory cache
                    this.memoryCache.rawData[key] = cacheEntry.data;
                    return cacheEntry.data;
                }
            }

            return null;
        },

        // Load initial data from localStorage
        loadFromLocalStorage() {
            Object.keys(localStorage)
                .filter(key => key.startsWith('calendarCache_'))
                .forEach(key => {
                    try {
                        const cacheEntry = JSON.parse(localStorage.getItem(key));
                        if (cacheEntry.version === this.CACHE_VERSION) {
                            const [year, month] = key.replace('calendarCache_', '').split('-');
                            this.memoryCache.rawData[`${year}-${month}`] = cacheEntry.data;
                        }
                    } catch (e) {
                        console.warn('Invalid cache entry:', key);
                    }
                });
        },

        // Clean expired cache entries
        cleanExpiredCache() {
            const now = Date.now();
            Object.keys(localStorage)
                .filter(key => key.startsWith('calendarCache_'))
                .forEach(key => {
                    try {
                        const cacheEntry = JSON.parse(localStorage.getItem(key));
                        if (now - cacheEntry.timestamp > this.CACHE_EXPIRY) {
                            localStorage.removeItem(key);
                        }
                    } catch (e) {
                        localStorage.removeItem(key);
                    }
                });
        },

        // Clear oldest entries when storage is full
        clearOldestEntries() {
            const cacheEntries = Object.keys(localStorage)
                .filter(key => key.startsWith('calendarCache_'))
                .map(key => ({
                    key,
                    timestamp: JSON.parse(localStorage.getItem(key)).timestamp
                }))
                .sort((a, b) => a.timestamp - b.timestamp);

            // Remove oldest 25% of entries
            const entriesToRemove = Math.ceil(cacheEntries.length * 0.25);
            cacheEntries.slice(0, entriesToRemove).forEach(entry => {
                localStorage.removeItem(entry.key);
            });
        },

        // Check if data needs refresh
        needsRefresh(month, year) {
            const cached = this.getData(month, year);
            return !cached || Date.now() - cached.timestamp > this.CACHE_EXPIRY;
        }
    };

    // Initialize filters
    function initializeFilters() {
        if (!isEmployee) {
            $.ajax({
                url: "../core/fetch_users.php",
                method: 'GET',
                dataType: "json",
                success: function (response) {
                    if (response) {
                        const $userSelect = $('#userFilter');
                        $userSelect.empty().append('<option value="">Select User</option>');
                        response.forEach(user => {
                            $userSelect.append($('<option>', {
                                value: user.id,
                                text: user.name
                            }));
                        });
                    }
                }
            });
        }

        $.ajax({
            url: "../core/fetch_categories.php",
            method: 'GET',
            dataType: "json",
            success: function (response) {
                if (response) {
                    const $categorySelect = $('#categoryFilter');
                    $categorySelect.empty().append('<option value="">Select Category</option>');
                    response.forEach(category => {
                        $categorySelect.append($('<option>', {
                            value: category.id,
                            text: category.name
                        }));
                    });
                }
            }
        });

        $('#categoryFilter, #userFilter').on('change', function () {
            applyFilters();
        });
    }

    // Apply filters to calendar events
    function applyFilters() {
        const categoryFilter = $('#categoryFilter').val();
        const userFilter = isEmployee ? '' : $('#userFilter').val();
        const currentMonthKey = `${CalendarCache.memoryCache.currentYear}-${CalendarCache.memoryCache.currentMonth}`;

        if (CalendarCache.memoryCache.rawData[currentMonthKey]) {
            const filteredEvents = filterEvents(CalendarCache.memoryCache.rawData[currentMonthKey], categoryFilter, userFilter);
            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
        }
    }

    // Filter events based on category and user
    function filterEvents(events, categoryId, userId) {
        return events.filter(event => {
            let matchesCategory = true;
            let matchesUser = true;

            if (categoryId) {
                matchesCategory = event.extendedProps.category_id === parseInt(categoryId);
            }

            if (userId && !isEmployee) {
                matchesUser = event.extendedProps.user_id === parseInt(userId);
            }

            return matchesCategory && matchesUser;
        });
    }

    // Load month data with caching
    function loadMonthData(month, year, callback) {
        const cachedData = CalendarCache.getData(month, year);

        if (cachedData) {
            console.log('Using cached data for', month, year);
            const filteredEvents = filterEvents(
                cachedData,
                $('#categoryFilter').val(),
                isEmployee ? '' : $('#userFilter').val()
            );
            if (callback) callback(filteredEvents);
            return;
        }

        console.log('Fetching fresh data for', month, year);
        const endpoint = isEmployee ? "../core/getUserTaskForCal.php" : "../core/fetchTaskForCal.php";

        $.ajax({
            url: endpoint,
            method: 'GET',
            dataType: 'json',
            data: {
                view: 'calendar',
                month: month,
                year: year
            },
            success: function (response) {
                if (response.status === 'success') {
                    const events = response.tasks.map(task => ({
                        id: task.id,
                        title: task.title,
                        start: task.due_time && task.due_time !== '00:00:00'
                            ? `${task.due_date}T${task.due_time}`
                            : task.due_date,
                        allDay: !task.due_time || task.due_time === '00:00:00',
                        backgroundColor: getStatusColor(task.status),
                        extendedProps: {
                            description: task.description,
                            category: task.category || task.category_name,
                            category_id: task.category_id,
                            status: task.status,
                            user_id: task.assigned_to,
                            assignedTo: task.username,
                            status_name: task.status_name,
                            due_time: task.due_time
                        }
                    }));

                    // Store in cache
                    CalendarCache.setData(month, year, events);

                    const filteredEvents = filterEvents(
                        events,
                        $('#categoryFilter').val(),
                        isEmployee ? '' : $('#userFilter').val()
                    );

                    if (callback) callback(filteredEvents);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading month data:', error);
                if (callback) callback([]);
            }
        });
    }

    function initializePopoverHeaderClick() {
        document.addEventListener('click', function (e) {
            // Check if clicked element is a popover header
            if (e.target.closest('.fc-popover-title')) {
                const popover = e.target.closest('.fc-popover');
                if (popover) {
                    // Extract the date from the header text
                    const headerText = popover.querySelector(' .fc-popover-title').textContent;
                    const date = new Date(headerText);

                    // Only proceed if we got a valid date
                    if (!isNaN(date.getTime())) {
                        // Change to day view for the clicked date
                        calendar.changeView('timeGridDay', date);

                        // Close the popover
                        const closeBtn = popover.querySelector('.fc-popover-close');
                        if (closeBtn) {
                            closeBtn.click();
                        }
                    }
                }
            }
        });
    }

    // Initialize calendar with new event limiting features
    function initializeCalendar() {
        const calendarEl = document.getElementById('calendar');

        // Add CSS for fixed event height in day view
        const styleElement = document.createElement('style');
        styleElement.textContent = `
            /* Fixed height for events in day view */
            .fc .fc-timegrid-event {
                height: 50px !important;
                max-height: 50px !important;
                overflow: hidden;
            }

            /* Better styling for day view events */
            .fc-timegrid-event .fc-event-main {
                padding: 2px 4px !important;
            }

            .fc-timegrid-event .fc-event-title {
                font-size: 1em;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        `;
        document.head.appendChild(styleElement);

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            dayMaxEvents: 2, // Limit number of events shown per day
            moreLinkContent: function (args) {
                return `+${args.num} more`; // Customize the "more" link text
            },
            moreLinkClick: function (info) {
                info.jsEvent.preventDefault();
                // showDayEventsModal(info.date, info.allSegs);
            },
            slotMinTime: '00:00:00',
            slotMaxTime: '24:00:00',
            displayEventTime: false,
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            datesSet: function (info) {
                const newMonth = info.view.currentStart.getMonth() + 1;
                const newYear = info.view.currentStart.getFullYear();

                // Only reload if month/year actually changed
                if (newMonth !== CalendarCache.memoryCache.currentMonth ||
                    newYear !== CalendarCache.memoryCache.currentYear) {
                    CalendarCache.memoryCache.currentMonth = newMonth;
                    CalendarCache.memoryCache.currentYear = newYear;
                    $('#categoryFilter, #userFilter').val('');

                    // Load data for the new month
                    loadMonthData(newMonth, newYear, function (events) {
                        calendar.removeAllEvents();
                        calendar.addEventSource(events);
                    });
                }
            },
            dateClick: function (info) {
                calendar.changeView('timeGridDay', info.dateStr);
            },
            eventClick: function (info) {
                info.jsEvent.preventDefault();
                displayEventDetails(info.event);
            },
            loading: function (isLoading) {
                if (isLoading) {
                    $('#loadingIndicator').show();
                } else {
                    $('#loadingIndicator').hide();
                }
            },
            eventDidMount: function (info) {
                if (info.view.type === 'dayGridMonth') {
                    info.el.style.backgroundColor = info.event.backgroundColor;
                    const eventElements = info.el.querySelectorAll('.fc-event-title, .fc-event-time');
                    eventElements.forEach(el => {
                        el.style.color = 'white';
                        el.style.fontWeight = "light";
                    });
                } else if (info.view.type === 'timeGridDay' || info.view.type === 'timeGridWeek') {
                    // Enforce fixed height for day/week view events and add styling
                    info.el.style.backgroundColor = info.event.backgroundColor;
                    info.el.style.height = '40px';
                    info.el.style.maxHeight = '40px';
                    info.el.style.overflow = 'hidden';

                    // Make text white and add ellipsis for overflow
                    const eventTitle = info.el.querySelector('.fc-event-title');
                    if (eventTitle) {
                        eventTitle.style.color = 'white';
                        eventTitle.style.whiteSpace = 'nowrap';
                        eventTitle.style.overflow = 'hidden';
                        eventTitle.style.textOverflow = 'ellipsis';
                    }

                    // Add tooltip with full title and description
                    const tooltipContent = `
                        <strong>${info.event.title}</strong><br>
                        ${info.event.extendedProps.description || 'No description'}<br>
                        Status: ${info.event.extendedProps.status_name}
                    `;

                    // Use Bootstrap tooltip if available, otherwise use title attribute
                    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                        info.el.setAttribute('data-bs-toggle', 'tooltip');
                        info.el.setAttribute('data-bs-html', 'true');
                        info.el.setAttribute('data-bs-title', tooltipContent);
                        new bootstrap.Tooltip(info.el);
                    } else {
                        info.el.setAttribute('title', info.event.title);
                    }
                }
            }
        });

        calendar.render();
        initializePopoverHeaderClick();
        // Load initial month's data
        const initialDate = calendar.getDate();
        CalendarCache.memoryCache.currentMonth = initialDate.getMonth() + 1;
        CalendarCache.memoryCache.currentYear = initialDate.getFullYear();

        loadMonthData(
            CalendarCache.memoryCache.currentMonth,
            CalendarCache.memoryCache.currentYear,
            function (events) {
                calendar.removeAllEvents();
                calendar.addEventSource(events);
            }
        );

        // Add loading indicator
        $('body').append(`
            <div id="loadingIndicator" style="display:none; position:fixed; top:50%; left:50%; 
                transform:translate(-50%,-50%); background:rgba(255,255,255,0.8); 
                padding:20px; border-radius:5px; z-index:9999;">
                Loading tasks...
            </div>
        `);
    }


    // Add this code at the end of your initializeCalendar function (before the closing brace)
    // Around line 484 in your paste-2.txt file:

    // Add loading indicator
    $('body').append(`
        <div id="loadingIndicator" style="display:none; position:fixed; top:50%; left:50%; 
            transform:translate(-50%,-50%); background:rgba(255,255,255,0.8); 
            padding:20px; border-radius:5px; z-index:9999;">
            Loading tasks...
        </div>
    `);

    // Call month selector initialization after a short delay
    // to ensure calendar is fully rendered
    setTimeout(() => {
        addFontAwesome();
        createMonthSelector();
    }, 500);


    // Add these functions after the initializeCalendar function

    // Function to create month selector button and modal
    function createMonthSelector() {
        // Add the month selector button next to the other toolbar buttons
        const calendarHeaderRight = document.querySelector('.fc-header-toolbar .fc-toolbar-chunk:last-child');

        if (calendarHeaderRight) {
            // Create a new button with Bootstrap styling
            const monthSelectorBtn = document.createElement('button');
            monthSelectorBtn.className = 'fc-button fc-button-primary ms-2';
            monthSelectorBtn.innerHTML = '<i class="fas fa-calendar-alt me-1"></i> Jump to Month';
            monthSelectorBtn.id = 'monthSelectorBtn';
            monthSelectorBtn.setAttribute('type', 'button');
            monthSelectorBtn.setAttribute('data-bs-toggle', 'modal');
            monthSelectorBtn.setAttribute('data-bs-target', '#monthSelectorModal');

            // Insert the button before the view selection buttons
            calendarHeaderRight.insertBefore(monthSelectorBtn, calendarHeaderRight.firstChild);
        }

        // Create the month selector modal
        const modalHtml = `
    <div class="modal fade" id="monthSelectorModal" tabindex="-1" aria-labelledby="monthSelectorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="monthSelectorModalLabel">Jump to Month</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="yearSelector" class="form-label">Select Year</label>
                            <select id="yearSelector" class="form-select">
                                ${generateYearOptions()}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        ${generateMonthButtons()}
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;

        // Add the modal to the document
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Add event listeners for the month buttons
        setupMonthSelectorEvents();
    }

    // Generate options for the year selector (current year ± 5 years)
    function generateYearOptions() {
        const currentYear = new Date().getFullYear();
        let options = '';

        for (let year = currentYear - 5; year <= currentYear + 5; year++) {
            const selected = year === currentYear ? 'selected' : '';
            options += `<option value="${year}" ${selected}>${year}</option>`;
        }

        return options;
    }

    // Generate month buttons for the modal
    function generateMonthButtons() {
        const months = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];

        let buttonsHtml = '';

        months.forEach((month, index) => {
            buttonsHtml += `
        <div class="col-4 mb-3">
            <button class="btn btn-outline-primary w-100 month-selector-btn" 
                    data-month="${index}">
                ${month}
            </button>
        </div>
        `;
        });

        return buttonsHtml;
    }

    // Set up event listeners for the month selector
    function setupMonthSelectorEvents() {
        // Add click handlers for month buttons
        document.querySelectorAll('.month-selector-btn').forEach(button => {
            button.addEventListener('click', function () {
                const monthIndex = parseInt(this.getAttribute('data-month'));
                const year = parseInt(document.getElementById('yearSelector').value);

                // Create a date object for the selected month (first day)
                const selectedDate = new Date(year, monthIndex, 1);

                // Navigate calendar to the selected month
                calendar.gotoDate(selectedDate);

                // Update cache variables
                CalendarCache.memoryCache.currentMonth = monthIndex + 1;
                CalendarCache.memoryCache.currentYear = year;

                // Load data for the selected month
                loadMonthData(
                    CalendarCache.memoryCache.currentMonth,
                    CalendarCache.memoryCache.currentYear,
                    function (events) {
                        calendar.removeAllEvents();
                        calendar.addEventSource(events);
                    }
                );

                // Close the modal
                const monthSelectorModal = document.getElementById('monthSelectorModal');
                const modal = bootstrap.Modal.getInstance(monthSelectorModal);
                modal.hide();
            });
        });

        // Add change handler for year selector
        document.getElementById('yearSelector').addEventListener('change', function () {
            // Highlight the current month when changing years
            updateCurrentMonthHighlight();
        });

        // Add event handler when modal is shown
        document.getElementById('monthSelectorModal').addEventListener('shown.bs.modal', function () {
            // Update year selector to current calendar year
            document.getElementById('yearSelector').value = CalendarCache.memoryCache.currentYear;
            // Highlight current month
            updateCurrentMonthHighlight();
        });
    }

    // Highlight the current month in the modal
    function updateCurrentMonthHighlight() {
        // Remove highlight from all buttons
        document.querySelectorAll('.month-selector-btn').forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        });

        // Add highlight to current month
        const currentMonthBtn = document.querySelector(`.month-selector-btn[data-month="${CalendarCache.memoryCache.currentMonth - 1}"]`);
        if (currentMonthBtn) {
            currentMonthBtn.classList.remove('btn-outline-primary');
            currentMonthBtn.classList.add('btn-primary');
        }
    }

    // Add Font Awesome if not already included
    function addFontAwesome() {
        if (!document.querySelector('link[href*="font-awesome"]')) {
            const fontAwesomeLink = document.createElement('link');
            fontAwesomeLink.rel = 'stylesheet';
            fontAwesomeLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
            document.head.appendChild(fontAwesomeLink);
        }
    }

    // New function to show all events for a specific day
    function showDayEventsModal(date, events) {
        const formattedDate = new Date(date).toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        document.querySelector('#taskDetailsModal .modal-title').textContent = `Tasks for ${formattedDate}`;

        const tasksList = document.getElementById('dayTasksList');
        tasksList.innerHTML = '';

        // Get all events for this day
        events.forEach(eventSeg => {
            const event = eventSeg.event;
            const detailsRow = document.createElement('tr');
            detailsRow.innerHTML = `
                <td><strong>${event.title}</strong></td>
                <td>${event.extendedProps.description || 'No description available'}</td>
                <td>${event.extendedProps.category}</td>
                ${isEmployee ? "" : `<td>${event.extendedProps.assignedTo}</td>`}
                <td>
                    <span class="badge" style="background-color: ${event.backgroundColor}">
                        ${event.extendedProps.status_name}
                    </span>
                </td>
            `;
            tasksList.appendChild(detailsRow);
        });

        // Add scrollable style to modal body
        const modalBody = document.querySelector('#taskDetailsModal .modal-body');
        modalBody.style.maxHeight = '70vh';
        modalBody.style.overflowY = 'auto';

        const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
        modal.show();
    }

    // Display event details in modal
    function displayEventDetails(event) {
        document.querySelector('#taskDetailsModal .modal-title').textContent = event.title;

        const tasksList = document.getElementById('dayTasksList');
        tasksList.innerHTML = '';

        const detailsRow = document.createElement('tr');
        detailsRow.innerHTML = `
            <td><strong>${event.title}</strong></td>
            <td>${event.extendedProps.description || 'No description available'}</td>
            <td>${event.extendedProps.category}</td>
            ${isEmployee ? "" : `<td>${event.extendedProps.assignedTo}</td>`}
            <td>
                <span class="badge" style="background-color: ${event.backgroundColor}">
                    ${event.extendedProps.status_name}
                </span>
            </td>
        `;
        tasksList.appendChild(detailsRow);

        // Add scrollable style
        const modalBody = document.querySelector('#taskDetailsModal .modal-body');
        modalBody.style.maxHeight = '70vh';
        modalBody.style.overflowY = 'auto';

        const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
        modal.show();
    }

    function getStatusColor(status) {
        const colors = {
            1: '#6c757d', // New - Grey
            2: '#17a2b8', // Started - Info
            3: '#ffc107', // On Hold - Warning
            4: '#28a745'  // Completed - Success
        };
        return colors[status] || '#6c757d';
    }

    // Cache monitoring utility
    function getCacheSize() {
        return Object.keys(localStorage)
            .filter(key => key.startsWith('calendarCache_'))
            .reduce((size, key) => size + localStorage.getItem(key).length, 0);
    }

    // Cache invalidation utility
    function invalidateCache(month, year) {
        const key = `${year}-${month}`;
        localStorage.removeItem(`calendarCache_${key}`);
        delete CalendarCache.memoryCache.rawData[key];
    }

    // Initialize the application
    CalendarCache.init();
    initializeFilters();
    initializeCalendar();
});
 