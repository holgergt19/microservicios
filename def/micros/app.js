const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const port = 8765; // o cualquier otro puerto que desees utilizar

app.use(bodyParser.json());

// Endpoint para la suma de dos números
app.get('/operacion/:num1/:num2/:operacion', (req, res) => {
    const { num1, num2, operacion } = req.params;
    if (operacion !== 'suma') {
        return res.status(400).json({ error: 'Operación no válida' });
    }
    if (isNaN(num1) || isNaN(num2)) {
        return res.status(400).json({ error: 'Los números deben ser válidos' });
    }

    const resultado = parseFloat(num1) + parseFloat(num2);
    return res.json({ resultado });
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor en funcionamiento en http://localhost:${port}`);
});
