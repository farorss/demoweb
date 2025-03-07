//อยู่คู่กับหน้าอ่านภาพ

import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
import { getStorage, ref, getDownloadURL, deleteObject } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-storage.js";

// ตั้งค่า Firebase
const firebaseConfig = {
  apiKey: "AIzaSyAQDzrW2mWlZ4JYjBqI-cmmcuKSQEx-Z2w",
  authDomain: "project-adw.firebaseapp.com",
  projectId: "project-adw",
  storageBucket: "project-adw.appspot.com",
  messagingSenderId: "432161617519",
  appId: "1:432161617519:web:676549153358a72675bf9a",
};

const app = initializeApp(firebaseConfig);
const storage = getStorage(app);

export async function fetchImage(fileName, elementId) {

  try {
    const filePath = fileName; // ใช้ path เดียวกับตอนอัปโหลด
    const fileRef = ref(storage, filePath);
    const url = await getDownloadURL(fileRef);
    document.getElementById(elementId).src = url; // อัปเดตรูปภาพในหน้าเว็บ
  } catch (error) {
    console.error("❌ โหลดภาพไม่สำเร็จ:", error);
  }
}

export async function deleteImage(filePath) {
  try {
      const fileRef = ref(storage, filePath);
      await deleteObject(fileRef);
      console.log("✅ ลบไฟล์สำเร็จ:", filePath);
  } catch (error) {
      console.error("❌ ลบไฟล์ไม่สำเร็จ:", error);
  }
}

export async function fetchImageAll(fileName, elementId) {
  try {
    const fileRef = ref(storage, fileName); // ใช้ URL หรือ path ของไฟล์
    const url = await getDownloadURL(fileRef);
    
    const imgElement = document.getElementById(elementId);
    if (imgElement) {
      imgElement.src = url; // อัปเดตรูปภาพในหน้าเว็บ
    }
  } catch (error) {
    console.error("❌ โหลดภาพไม่สำเร็จ:", error);
  }
}
