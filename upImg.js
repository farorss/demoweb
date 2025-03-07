import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js"; // เก็บข้อมูล
import { getStorage, ref, uploadBytes, deleteObject } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-storage.js"; // ติดต่อกับ storage

const firebaseConfig = {
  apiKey: "AIzaSyAQDzrW2mWlZ4JYjBqI-cmmcuKSQEx-Z2w",
  authDomain: "project-adw.firebaseapp.com",
  databaseURL: "https://project-adw-default-rtdb.firebaseio.com",
  projectId: "project-adw",
  storageBucket: "project-adw.appspot.com",
  messagingSenderId: "432161617519",
  appId: "1:432161617519:web:676549153358a72675bf9a",
  measurementId: "G-NYNKTVFQWC"
};

// ✅ 1️⃣ เรียกใช้ Firebase Storage

const app = initializeApp(firebaseConfig);
const storage = getStorage(app);

const fileUpload = document.getElementById("imageUpload");
const deleteButton = document.getElementById("deleteFile");

fileUpload.addEventListener("change", async (e) => {
  const file = e.target.files[0];

  const fileName = `wedPro/${file.name}`; // ใช้ชื่อไฟล์จริงจากการอัปโหลด
  const imgRef = ref(storage, fileName); // สร้าง reference ใน Firebase Storage

  try {
    await uploadBytes(imgRef, file); // อัปโหลดไฟล์ไปยัง Firebase Storage
    alert("✅ อัปโหลดไฟล์สำเร็จ!");

    // เก็บชื่อไฟล์ใน localStorage เพื่อส่งไปฐานข้อมูล
    localStorage.setItem("uploadedFile", fileName);
  } catch (error) {
    console.error("❌ อัปโหลดผิดพลาด:", error);
  }
});

// 🗑️ 2️⃣ ลบไฟล์ออกจาก Firebase และกลับไปที่ index.php
deleteButton.addEventListener("click", async () => {
  const fileName = localStorage.getItem("uploadedFile");

  const imgRef = ref(storage, fileName);

  try {
    await deleteObject(imgRef);
    alert("✅ ลบไฟล์สำเร็จ!");
    localStorage.removeItem("uploadedFile"); // ล้างค่าที่บันทึกไว้
    window.location.href = "index.php"; // กลับไปที่ index.php
  } catch (error) {
    console.error("❌ ลบไฟล์ผิดพลาด:", error);
  }
});

document.getElementById("uploadForm").addEventListener("submit", function(e) {
    const fileName = localStorage.getItem("uploadedFile"); // ดึงชื่อไฟล์จาก localStorage
    if (fileName) {
        document.getElementById("img").value = fileName; // ส่งชื่อไฟล์ไปยัง input hidden ในฟอร์ม
    }
});

