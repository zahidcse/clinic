(function () {
  document.addEventListener("DOMContentLoaded", function () {
    /* initialize the external events
      -----------------------------------------------------------------*/

    /*var containerEl = document.getElementById("external-events-list");
    new FullCalendar.Draggable(containerEl, {
      itemSelector: ".fc-event",
      eventData: function (eventEl) {
        return {
          title: eventEl.innerText.trim(),
        };
      },
    });*/

    //// the individual way to do it
    // var containerEl = document.getElementById('external-events-list');
    // var eventEls = Array.prototype.slice.call(
    //   containerEl.querySelectorAll('.fc-event')
    // );
    // eventEls.forEach(function(eventEl) {
    //   new FullCalendar.Draggable(eventEl, {
    //     eventData: {
    //       title: eventEl.innerText.trim(),
    //     }
    //   });
    // });

    /* initialize the calendar
      -----------------------------------------------------------------*/

    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
      },
      initialView: "dayGridMonth",
      initialDate: "2024-11-12",
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      nowIndicator: true,
      // dayMaxEvents: true, // allow "more" link when too many events
      events: [
        {
          title: "All Day Event",
          start: "2024-11-01",
          backgroundColor:"#F38744"
        },
        {
          title: "Phone consultation.",
          start: "2024-11-07T11:00:00",
          end: "2024-11-07T12:00:00",
          backgroundColor:"#7E0EAD"
        },
        {
          title: "Phone consultation.",
          start: "2024-11-07T01:00:00",
          end: "2024-11-07T02:00:00",
          backgroundColor:"#7E0EAD"
        },
        {
          title: "Phone consultation.",
          start: "2024-11-13T11:00:00",
          end: "2024-11-13T12:00:00",
          backgroundColor:"#7E0EAD"
        },
        {
          title: "Phone consultation.",
          start: "2024-11-14T10:00:00",
          end: "2024-11-14T12:00:00",
          backgroundColor:"#7E0EAD"
        },
        {
          title: "Phone consultation.",
          start: "2024-11-15T11:30:00",
          end: "2024-11-15T12:00:00",
          backgroundColor:"#7E0EAD"
        },
        {
          groupId: 999,
          title: "Meeting with Team",
          start: "2024-11-11T16:00:00",

        },
        {
          groupId: 999,
          title: "Upload New Project",
          start: "2024-11-16T16:00:00",
        },
        {
          title: "Lunch",
          start: "2024-11-30T12:00:00",
        },
        {
          title: "Meeting",
          start: "2024-11-12T14:30:00",
        },
        {
          title: "Happy Hour",
          start: "2024-11-30T17:30:00",
        },
      ],
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function (arg) {
        // is the "remove after drop" checkbox checked?
        if (document.getElementById("drop-remove").checked) {
          // if so, remove the element from the "Draggable Events" list
          arg.draggedEl.parentNode.removeChild(arg.draggedEl);
        }
      },
    });
    calendar.render();
  });
})();
