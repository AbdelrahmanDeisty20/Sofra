import './bootstrap';
import '../css/app.css';

import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './components/App';

console.log("Starting React application...");
if (document.getElementById('root')) {
    console.log("Root element found, rendering...");
    ReactDOM.createRoot(document.getElementById('root')).render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
} else {
    console.error("Root element not found!");
}
