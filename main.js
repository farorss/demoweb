function goToDetailsPost(text, image) {
    window.location.href = "detailsJoined.php?text=" + text + "&image=" + image;
}


//  เพื่อส่งข้อมูลไปที่ creator_edits_post_event.php
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".edit-button").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault(); // ป้องกันการโหลดหน้าใหม่ทันที

            let text = this.getAttribute("data-text");
            let image = this.getAttribute("data-image");

            // ไปที่หน้า creator_edits_post_event.php พร้อมส่งข้อมูลไปด้วย
            window.location.href = `creator_edits_post_event.php?text=${encodeURIComponent(text)}&image=${encodeURIComponent(image)}`;
        });
    });
});


// dropdown
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".dropdown-toggle").forEach((toggle, index) => {
        const menu = document.getElementById(`dropdownMenu-${index}`);

        toggle.addEventListener("click", function(event) {
            event.stopPropagation();

            // ปิด dropdown ทั้งหมดก่อน
            document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
                if (dropdown !== menu) { // ยกเว้นอันที่กำลังกด
                    dropdown.classList.remove("show");
                }
            });

            // เปิด/ปิดเฉพาะ dropdown ที่กด
            menu.classList.toggle("show");
        });
    });

    // คลิกที่อื่น => ปิด dropdown ทั้งหมด
    document.addEventListener("click", function() {
        document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
            dropdown.classList.remove("show");
        });
    });

    // ป้องกัน dropdown ปิดเมื่อคลิกข้างใน
    document.querySelectorAll(".dropdown-menu").forEach(menu => {
        menu.addEventListener("click", function(event) {
            event.stopPropagation();
        });
    });
});


// สลับแท็บระหว่าง "my event" และ "joined Event" 
document.addEventListener("DOMContentLoaded", function() {
    const myEventTab = document.getElementById("myEventTab");
    const joinedEventTab = document.getElementById("joinedEventTab");
    const cardsEvent = document.querySelector(".cardsEvent");
    const joinedEvent = document.querySelector(".joinedEvent");

    function setActiveTab(clickedTab) {
        myEventTab.classList.remove("active");
        joinedEventTab.classList.remove("active");

        if (clickedTab === "myEvent") {
            myEventTab.classList.add("active");
            cardsEvent.style.display = "flex";
            joinedEvent.style.display = "none";
        } else {
            joinedEventTab.classList.add("active");
            joinedEvent.style.display = "flex";
            cardsEvent.style.display = "none";
        }
    }

    myEventTab.addEventListener("click", function() {
        setActiveTab("myEvent");
    });

    joinedEventTab.addEventListener("click", function() {
        setActiveTab("joinedEvent");
    });

    // ตั้งค่าเริ่มต้นให้แสดง myEvent
    setActiveTab("myEvent");
});


document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll(".btn-link");

    buttons.forEach(button => {
        button.addEventListener("click", function() {
            buttons.forEach(btn => btn.classList.remove("active")); // ลบ active ออกจากปุ่มทั้งหมด
            this.classList.add("active"); // เพิ่ม active ให้ปุ่มที่ถูกกด
        });
    });
});

document.querySelector(".btn").addEventListener("click", function() {
    this.classList.toggle("active");
});

function toggleText(cardTitle) {
    var textContainer = document.querySelector('#text-' + cardTitle);
    var button = textContainer.nextElementSibling;

    if (textContainer.style.webkitLineClamp === "2") {
        textContainer.style.webkitLineClamp = "unset"; // แสดงข้อความทั้งหมด
        textContainer.style.overflow = "visible";
        button.textContent = "See less";
    } else {
        textContainer.style.webkitLineClamp = "2"; // ซ่อนข้อความเหลือ 3 บรรทัด
        textContainer.style.overflow = "hidden";
        button.textContent = "See more";
    }
}

function toggleText(index) {
    let textElement = document.getElementById("text-" + index);
    let button = textElement.nextElementSibling;
    
    if (textElement.style.display === "-webkit-box") {
        textElement.style.display = "block";
        button.textContent = "See less";
    } else {
        textElement.style.display = "-webkit-box";
        button.textContent = "See more";
    }
}

function toggleEvent(eventType) {
            const allEvents = document.querySelectorAll('.cardsEvent');
            allEvents.forEach(event => {
                event.classList.remove('active');
            });

            const selectedEvent = document.querySelector(`.${eventType}`);
            selectedEvent.classList.add('active');
        }

