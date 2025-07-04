// $(document).ready(function () {
//   // Function to fetch and display tasks
//   const statusLabels = {
//     1: "New",
//     2: "Started",
//     3: "On Hold",
//     4: "Completed",
//   };
//   const statusColors = {
//     1: "bg-secondary",
//     2: "bg-info",
//     3: "bg-warning",
//     4: "bg-success",
//   };
//   function loadTasks() {
//     $.ajax({
//       url: "../core/fetchTask.php", // PHP script to fetch tasks from the database
//       type: "GET",
//       dataType: "json",
//       success: function (response) {
//         let taskHTML = "";
//         response.forEach(function (task, idx) {
//           taskHTML += `
//                         <tr class="${(idx < response.length - 1) ? "border-bottom" : "border-none"}">
//                         <td class="text-center align-top text-capitalize">${task.username
//             }</td>
//                         <td class="task-col text-capitalize">
//                           <strong>${task.title}</strong><br>
//                           <span style="color: gray;">${task.description}.</span>
//                         </td>
//                         <td>${task.category}</td>
//                         <td class="text-center">
// <span class="badge badge-sm  ${statusColors?.[task.status]}">
//      ${statusLabels?.[task.status]}
//     </span>

//                         </td>
//                         <td>${task.due_date
//               ?.split("-")
//               .reverse()
//               .join("-")}</td>
//                         <td class="actions-dropdown">
//                           <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
//                             Actions
//                           </button>
//                           <ul class="dropdown-menu">
//   <li>
//     <button class="dropdown-item edit-task d-flex align-items-center" data-id="${task.id
//             }">
//       <i class="material-symbols-rounded me-2">edit</i> Edit
//     </button>
//   </li>
//   <li>
//     <button class="dropdown-item text-danger delete-task d-flex align-items-center" data-id="${task.id
//             }">
//       <i class="material-symbols-rounded me-2">delete</i> Delete
//     </button>
//   </li>
// </ul>

//                         </td>
//                       </tr>

//                     `;
//         });
//         $("#taskTableBody").html(taskHTML);
//       },
//       error: function (xhr) {
//         console.error("Error fetching tasks:", xhr.responseText);
//       },
//     });
//   }

//   // Call function to load tasks initially
//   loadTasks();

//   // Handle form submission to update the task
//   $(document).on("click", ".edit-task", function () {
//     let taskId = $(this).data("id");
//     window.location.href = `editTask.php?id=${taskId}`;
//   });

//   // Handle delete button click
//   //   $(document).on("click", ".delete-task", function () {
//   //     let taskId = $(this).data("id");
//   //     Swal.fire({
//   //   title: "Are you sure?",
//   //   text: "You want to delete this task!",
//   //   icon: "warning",
//   //   showCancelButton: true,
//   //   confirmButtonColor: "#3085d6",
//   //   cancelButtonColor: "#d33",
//   //   confirmButtonText: "Yes, delete it!"
//   // }).then((result) => {
//   //   if (result.isConfirmed) {
//   //    $.ajax({
//   //         url: "../core/deleteTask.php",
//   //         type: "POST",
//   //         contentType: "application/json",
//   //         data: JSON.stringify({ id: taskId }),
//   //         success: function (response) {
//   //           // alert(response.message);
//   //             Swal.fire({
//   //       title: "Deleted!",
//   //       text: "Your file has been deleted.",
//   //       icon: "success"
//   //     });

//   //       });
//   //        error: function (xhr) {
//   //           console.error("Error deleting task:", xhr.responseText);
//   //         },

//   //   }
//   // });
//   $(document).on("click", ".delete-task", function () {
//     let taskId = $(this).data("id");

//     Swal.fire({
//       title: "Are you sure?",
//       text: "You want to delete this task!",
//       icon: "warning",
//       showCancelButton: true,
//       confirmButtonColor: "#3085d6",
//       cancelButtonColor: "#d33",
//       confirmButtonText: "Yes, delete it!"
//     }).then((result) => {
//       if (result.isConfirmed) {
//         $.ajax({
//           url: "../core/deleteTask.php",
//           type: "POST",
//           contentType: "application/json",
//           data: JSON.stringify({ id: taskId }),
//           success: function (response) {
//             Swal.fire({
//               title: "Deleted!",
//               text: "Your file has been deleted.",
//               icon: "success"
//             });
//             loadTasks();
//           },
//           error: function (xhr) {
//             console.error("Error deleting task:", xhr.responseText);
//           }
//         });
//       }
//     });
//   });


// });












// $(document).ready(function () {
//   const statusLabels = {
//     1: "New",
//     2: "Started",
//     3: "On Hold",
//     4: "Completed",
//   };
//   const statusColors = {
//     1: "bg-secondary",
//     2: "bg-info",
//     3: "bg-warning",
//     4: "bg-success",
//   };

//   function loadTasks(page = 1) {
//     $.ajax({
//       url: "../core/fetchTask.php",
//       type: "GET",
//       data: { page: page },
//       dataType: "json",
//       success: function (response) {
//         let taskHTML = "";
//         response.tasks.forEach(function (task, idx) {
//           taskHTML += `
//             <tr class="${(idx < response.tasks.length - 1) ? "border-bottom" : "border-none"}">
//               <td class="text-center align-top text-capitalize">${task.username}</td>
//               <td class="task-col text-capitalize">
//                 <strong>${task.title}</strong><br>
//                 <span style="color: gray;">${task.description}</span>
//               </td>
//               <td>${task.category}</td>
//               <td class="text-center">
//                 <span class="badge badge-sm ${statusColors[task.status]}">
//                   ${statusLabels[task.status]}
//                 </span>
//               </td>
//               <td>${task.due_date?.split("-").reverse().join("-")}</td>
//               <td class="actions-dropdown">
//                 <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
//                   Actions
//                 </button>
//                 <ul class="dropdown-menu">
//                   <li>
//                     <button class="dropdown-item edit-task d-flex align-items-center" data-id="${task.id}">
//                       <i class="material-symbols-rounded me-2">edit</i> Edit
//                     </button>
//                   </li>
//                   <li>
//                     <button class="dropdown-item text-danger delete-task d-flex align-items-center" data-id="${task.id}">
//                       <i class="material-symbols-rounded me-2">delete</i> Delete
//                     </button>
//                   </li>
//                 </ul>
//               </td>
//             </tr>
//           `;
//         });

//         $("#taskTableBody").html(taskHTML);

//         // Generate pagination buttons
//         if (response.pagination && response.pagination.totalPages > 1) {
//           let paginationHTML = '<div class="d-flex gap-2">';

//           // Previous button
//           if (page > 1) {
//             paginationHTML += `
//               <button class="btn btn-sm btn-primary" onclick="loadPage(${page - 1})">
//                 Previous
//               </button>
//             `;
//           }

//           // Page numbers
//           for (let i = 1; i <= response.pagination.totalPages; i++) {
//             paginationHTML += `
//               <button class="btn btn-sm ${page === i ? 'btn-primary' : 'btn-outline-primary'}" 
//                       onclick="loadPage(${i})">
//                 ${i}
//               </button>
//             `;
//           }

//           // Next button
//           if (page < response.pagination.totalPages) {
//             paginationHTML += `
//               <button class="btn btn-sm btn-primary" onclick="loadPage(${page + 1})">
//                 Next
//               </button>
//             `;
//           }

//           paginationHTML += '</div>';
//           $("#paginationContainer").html(paginationHTML);
//         } else {
//           $("#paginationContainer").html('');
//         }
//       },
//       error: function (xhr) {
//         console.error("Error fetching tasks:", xhr.responseText);
//       },
//     });
//   }

//   // Define loadPage function in global scope
//   window.loadPage = function (page) {
//     loadTasks(page);
//   };

//   // Initial load
//   loadTasks(1);

//   // Handle edit task
//   $(document).on("click", ".edit-task", function () {
//     let taskId = $(this).data("id");
//     window.location.href = `editTask.php?id=${taskId}`;
//   });

//   // Handle delete task
//   $(document).on("click", ".delete-task", function () {
//     let taskId = $(this).data("id");

//     Swal.fire({
//       title: "Are you sure?",
//       text: "You want to delete this task!",
//       icon: "warning",
//       showCancelButton: true,
//       confirmButtonColor: "#3085d6",
//       cancelButtonColor: "#d33",
//       confirmButtonText: "Yes, delete it!"
//     }).then((result) => {
//       if (result.isConfirmed) {
//         $.ajax({
//           url: "../core/deleteTask.php",
//           type: "POST",
//           contentType: "application/json",
//           data: JSON.stringify({ id: taskId }),
//           success: function (response) {
//             Swal.fire({
//               title: "Deleted!",
//               text: "Your file has been deleted.",
//               icon: "success"
//             });
//             loadTasks(1); // Reload first page after deletion
//           },
//           error: function (xhr) {
//             console.error("Error deleting task:", xhr.responseText);
//           }
//         });
//       }
//     });
//   });
// });





// $(document).ready(function () {
//   const statusLabels = {
//     1: "New",
//     2: "Started",
//     3: "On Hold",
//     4: "Completed",
//   };
//   const statusColors = {
//     1: "bg-secondary",
//     2: "bg-info",
//     3: "bg-warning",
//     4: "bg-success",
//   };

//   function loadTasks(page = 1) {
//     $.ajax({
//       url: "../core/fetchTask.php",
//       type: "GET",
//       data: { page: page },
//       dataType: "json",
//       success: function (response) {
//         let taskHTML = "";
//         response.tasks.forEach(function (task, idx) {
//           taskHTML += `
//             <tr class="${(idx < response.tasks.length - 1) ? "border-bottom" : "border-none"}">
//               <td class="text-center align-top text-capitalize">${task.username}</td>
//               <td class="task-col text-capitalize">
//                 <strong>${task.title}</strong><br>
//                 <span style="color: gray;">${task.description}</span>
//               </td>
//               <td>${task.category}</td>
//               <td class="text-center">
//                 <span class="badge badge-sm ${statusColors[task.status]}">
//                   ${statusLabels[task.status]}
//                 </span>
//               </td>
//               <td>${task.due_date?.split("-").reverse().join("-")}</td>
//               <td class="actions-dropdown">
//                 <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
//                   Actions
//                 </button>
//                 <ul class="dropdown-menu">
//                   <li>
//                     <button class="dropdown-item edit-task d-flex align-items-center" data-id="${task.id}">
//                       <i class="material-symbols-rounded me-2">edit</i> Edit
//                     </button>
//                   </li>
//                   <li>
//                     <button class="dropdown-item text-danger delete-task d-flex align-items-center" data-id="${task.id}">
//                       <i class="material-symbols-rounded me-2">delete</i> Delete
//                     </button>
//                   </li>
//                 </ul>
//               </td>
//             </tr>
//           `;
//         });

//         $("#taskTableBody").html(taskHTML);

//         // Generate improved pagination with limited page numbers
//         if (response.pagination && response.pagination.totalPages > 1) {
//           let paginationHTML = '<div class="d-flex gap-2 align-items-center">';
//           const currentPage = parseInt(response.pagination.currentPage);
//           const totalPages = parseInt(response.pagination.totalPages);
//           const pagesPerGroup = 20;

//           // Calculate current group and bounds
//           const currentGroup = Math.floor((currentPage - 1) / pagesPerGroup);
//           const startPage = currentGroup * pagesPerGroup + 1;
//           const endPage = Math.min(startPage + pagesPerGroup - 1, totalPages);

//           // First page and previous group buttons
//           if (currentPage > 1) {
//             paginationHTML += `
//               <button class="btn btn-sm btn-outline-primary" onclick="loadPage(1)" title="First Page">
//                 <i class="bi bi-chevron-double-left"></i>
//               </button>
//             `;

//             if (currentGroup > 0) {
//               const prevGroupPage = (currentGroup - 1) * pagesPerGroup + 1;
//               paginationHTML += `
//                 <button class="btn btn-sm btn-outline-primary" onclick="loadPage(${prevGroupPage})" title="Previous Group">
//                   <i class="bi bi-chevron-left"></i><i class="bi bi-chevron-left"></i>
//                 </button>
//               `;
//             }
//           }

//           // Previous page button
//           if (currentPage > 1) {
//             paginationHTML += `
//               <button class="btn btn-sm btn-outline-primary" onclick="loadPage(${currentPage - 1})" title="Previous Page">
//                 <i class="bi bi-chevron-left"></i>
//               </button>
//             `;
//           }

//           // Page numbers (limited to current group)
//           paginationHTML += `<div class="d-flex flex-wrap" style="max-width: 300px;">`;
//           for (let i = startPage; i <= endPage; i++) {
//             paginationHTML += `
//               <button class="btn btn-sm ${currentPage === i ? 'btn-primary' : 'btn-outline-primary'}" 
//                       onclick="loadPage(${i})" style="margin: 2px;">
//                 ${i}
//               </button>
//             `;
//           }
//           paginationHTML += `</div>`;

//           // Next page button
//           if (currentPage < totalPages) {
//             paginationHTML += `
//               <button class="btn btn-sm btn-outline-primary" onclick="loadPage(${currentPage + 1})" title="Next Page">
//                 <i class="bi bi-chevron-right"></i>
//               </button>
//             `;
//           }

//           // Next group and last page buttons
//           if (currentPage < totalPages) {
//             if (currentGroup < Math.floor((totalPages - 1) / pagesPerGroup)) {
//               const nextGroupPage = (currentGroup + 1) * pagesPerGroup + 1;
//               paginationHTML += `
//                 <button class="btn btn-sm btn-outline-primary" onclick="loadPage(${nextGroupPage})" title="Next Group">
//                   <i class="bi bi-chevron-right"></i><i class="bi bi-chevron-right"></i>
//                 </button>
//               `;
//             }

//             paginationHTML += `
//               <button class="btn btn-sm btn-outline-primary" onclick="loadPage(${totalPages})" title="Last Page">
//                 <i class="bi bi-chevron-double-right"></i>
//               </button>
//             `;
//           }

//           // Add current position indicator
//           paginationHTML += `<span class="ms-2 text-secondary">Page ${currentPage} of ${totalPages}</span>`;

//           paginationHTML += '</div>';
//           $("#paginationContainer").html(paginationHTML);
//         } else {
//           $("#paginationContainer").html('');
//         }
//       },
//       error: function (xhr) {
//         console.error("Error fetching tasks:", xhr.responseText);
//       },
//     });
//   }

//   // Define loadPage function in global scope
//   window.loadPage = function (page) {
//     loadTasks(page);
//   };

//   // Initial load
//   loadTasks(1);

//   // Handle edit task
//   $(document).on("click", ".edit-task", function () {
//     let taskId = $(this).data("id");
//     window.location.href = `editTask.php?id=${taskId}`;
//   });

//   // Handle delete task
//   $(document).on("click", ".delete-task", function () {
//     let taskId = $(this).data("id");

//     Swal.fire({
//       title: "Are you sure?",
//       text: "You want to delete this task!",
//       icon: "warning",
//       showCancelButton: true,
//       confirmButtonColor: "#3085d6",
//       cancelButtonColor: "#d33",
//       confirmButtonText: "Yes, delete it!"
//     }).then((result) => {
//       if (result.isConfirmed) {
//         $.ajax({
//           url: "../core/deleteTask.php",
//           type: "POST",
//           contentType: "application/json",
//           data: JSON.stringify({ id: taskId }),
//           success: function (response) {
//             Swal.fire({
//               title: "Deleted!",
//               text: "Your file has been deleted.",
//               icon: "success"
//             });
//             loadTasks(1); // Reload first page after deletion
//           },
//           error: function (xhr) {
//             console.error("Error deleting task:", xhr.responseText);
//           }
//         });
//       }
//     });
//   });
// });




$(document).ready(function () {
  const statusLabels = {
    1: "New",
    2: "Started",
    3: "On Hold",
    4: "Completed",
  };
  const statusColors = {
    1: "bg-secondary",
    2: "bg-info",
    3: "bg-warning",
    4: "bg-success",
  };

  function loadTasks(page = 1) {
    $.ajax({
      url: "../core/fetchTask.php",
      type: "GET",
      data: { page: page },
      dataType: "json",
      success: function (response) {
        let taskHTML = "";
        response.tasks.forEach(function (task, idx) {
          taskHTML += `
            <tr class="${(idx < response.tasks.length - 1) ? "border-bottom" : "border-none"}">
              <td class="text-center align-top text-capitalize">${task.username}</td>
              <td class="task-col text-capitalize">
                <strong>${task.title}</strong><br>
                <span style="color: gray;">${task.description}</span>
              </td>
              <td>${task.category}</td>
              <td class="text-center">
                <span class="badge badge-sm ${statusColors[task.status]}">
                  ${statusLabels[task.status]}
                </span>
              </td>
              <td>${task.due_date?.split("-").reverse().join("-")}</td>
              <td class="actions-dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                  Actions
                </button>
                <ul class="dropdown-menu">
                  <li>
                    <button class="dropdown-item edit-task d-flex align-items-center" data-id="${task.id}">
                      <i class="material-symbols-rounded me-2">edit</i> Edit
                    </button>
                  </li>
                  <li>
                    <button class="dropdown-item text-danger delete-task d-flex align-items-center" data-id="${task.id}">
                      <i class="material-symbols-rounded me-2">delete</i> Delete
                    </button>
                  </li>
                </ul>
              </td>
            </tr>
          `;
        });

        $("#taskTableBody").html(taskHTML);

        // Generate improved pagination with limited page numbers on a single line
        if (response.pagination && response.pagination.totalPages > 1) {
          let paginationHTML = '<div class="d-flex gap-2 align-items-center justify-content-center">';
          const currentPage = parseInt(response.pagination.currentPage);
          const totalPages = parseInt(response.pagination.totalPages);
          const pagesPerGroup = 5; // Reduced number to fit in a single line

          // Calculate current group and bounds
          const currentGroup = Math.floor((currentPage - 1) / pagesPerGroup);
          const startPage = currentGroup * pagesPerGroup + 1;
          const endPage = Math.min(startPage + pagesPerGroup - 1, totalPages);

          // First page button
          paginationHTML += `
            <button class="btn btn-sm btn-outline-info" onclick="loadPage(1)" title="First Page">
              <i class="bi bi-chevron-double-left"></i>
            </button>
          `;

          // Previous group button
          if (currentGroup > 0) {
            const prevGroupPage = (currentGroup - 1) * pagesPerGroup + 1;
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info"  onclick="loadPage(${prevGroupPage})" title="Previous Group">
                <i class="bi bi-chevron-left"></i><i class="bi bi-chevron-left"></i>
              </button>
            `;
          } else {
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info disabled" title="Previous Group">
                <i class="bi bi-chevron-left"></i><i class="bi bi-chevron-left"></i>
              </button>
            `;
          }

          // Previous page button
          if (currentPage > 1) {
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info" onclick="loadPage(${currentPage - 1})" title="Previous Page">
                <i class="bi bi-chevron-left"></i>
              </button>
            `;
          } else {
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info disabled" title="Previous Page">
                <i class="bi bi-chevron-left"></i>
              </button>
            `;
          }

          // Page numbers (limited to current group)
          for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
              <button class="btn btn-sm ${currentPage === i ? 'btn-info' : 'btn-outline-info'}" 
                      onclick="loadPage(${i})" style="min-width: 40px;">
                ${i}
              </button>
            `;
          }

          // Next page button
          if (currentPage < totalPages) {
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info" onclick="loadPage(${currentPage + 1})" title="Next Page">
                <i class="bi bi-chevron-right"></i>
              </button>
            `;
          } else {
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info disabled" title="Next Page">
                <i class="bi bi-chevron-right"></i>
              </button>
            `;
          }

          // Next group button
          if (currentGroup < Math.floor((totalPages - 1) / pagesPerGroup)) {
            const nextGroupPage = (currentGroup + 1) * pagesPerGroup + 1;
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info" onclick="loadPage(${nextGroupPage})" title="Next Group">
                <i class="bi bi-chevron-right"></i><i class="bi bi-chevron-right"></i>
              </button>
            `;
          } else {
            paginationHTML += `
              <button class="btn btn-sm btn-outline-info disabled" title="Next Group">
                <i class="bi bi-chevron-right"></i><i class="bi bi-chevron-right"></i>
              </button>
            `;
          }

          // Last page button
          paginationHTML += `
            <button class="btn btn-sm btn-outline-info" onclick="loadPage(${totalPages})" title="Last Page">
              <i class="bi bi-chevron-double-right"></i>
            </button>
          `;

          // Add current position indicator
          paginationHTML += `<span class="ms-2 text-secondary">Page ${currentPage} of ${totalPages}</span>`;

          paginationHTML += '</div>';
          $("#paginationContainer").html(paginationHTML);
        } else {
          $("#paginationContainer").html('');
        }
      },
      error: function (xhr) {
        console.error("Error fetching tasks:", xhr.responseText);
      },
    });
  }

  // Define loadPage function in global scope
  window.loadPage = function (page) {
    loadTasks(page);
  };

  // Initial load
  loadTasks(1);

  // Handle edit task
  $(document).on("click", ".edit-task", function () {
    let taskId = $(this).data("id");
    window.location.href = `editTask.php?id=${taskId}`;
  });

  // Handle delete task
  $(document).on("click", ".delete-task", function () {
    let taskId = $(this).data("id");

    Swal.fire({
      title: "Are you sure?",
      text: "You want to delete this task!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../core/deleteTask.php",
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({ id: taskId }),
          success: function (response) {
            Swal.fire({
              title: "Deleted!",
              text: "Your file has been deleted.",
              icon: "success"
            });
            loadTasks(1); // Reload first page after deletion
          },
          error: function (xhr) {
            console.error("Error deleting task:", xhr.responseText);
          }
        });
      }
    });
  });
});