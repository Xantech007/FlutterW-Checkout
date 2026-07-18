// firebase.js — 9jaCash
// Initialize Firebase and export _9jaCash global for all pages

const firebaseConfig = {
  apiKey: "AIzaSyBgCwHqhwZbbuTmtxhMO7WR66aVahva42k",
  authDomain: "smp-9jacash.firebaseapp.com",
  databaseURL: "https://smp-9jacash-default-rtdb.firebaseio.com",
  projectId: "smp-9jacash",
  storageBucket: "smp-9jacash.firebasestorage.app",
  messagingSenderId: "264734179763",
  appId: "1:264734179763:web:249c96e74595752b844bc6",
  measurementId: "G-WZET3YPG4Y"
};


// Initialize Firebase
if (typeof firebase !== 'undefined') {
  firebase.initializeApp(firebaseConfig);
  console.log('Firebase initialized successfully');

  // Create the _9jaCash global object that ALL pages expect
  window._9jaCash = {
    app: firebase.app(),
    db: firebase.firestore(),
    auth: firebase.auth(),
    analytics: firebase.analytics ? firebase.analytics() : null
  };

  console.log('_9jaCash ready:', !!window._9jaCash.db);
} else {
  console.warn('Firebase SDK not loaded');
}

// Also keep old export for compatibility
window.firebaseApp = firebase;

// Create first admin account helper (run once in console)
async function createFirstAdmin(email, password) {
  try {
    const userCredential = await firebase.auth().createUserWithEmailAndPassword(email, password);
    const user = userCredential.user;
    
    await firebase.firestore().collection('admins').doc(user.uid).set({
      email: email,
      role: 'admin',
      createdAt: firebase.firestore.FieldValue.serverTimestamp(),
      isActive: true
    });
    
    console.log('Admin created successfully:', user.uid);
    return user;
  } catch (error) {
    console.error('Error creating admin:', error);
  }
}

window.createFirstAdmin = createFirstAdmin;
