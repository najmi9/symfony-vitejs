import './css/style.css';

(async () => {
    console.log('====================================');
    console.log('I  am In main.js');
    console.log('====================================');
    const app = await import('./app');
    console.log('====================================');
    app.default();
    console.log('====================================');
})()