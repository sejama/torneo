import Button from 'react-bootstrap/Button';
import Form from 'react-bootstrap/Form';
import { useState } from "react";
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

function FormEquipo() {
    const [nombre, setNombre] = useState("");
    const [observacion, setObservacion] = useState("");
    const [validated, setValidated] = useState(false);

    let handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await fetch("http://localhost:8000/api/equipo", {
                method: "POST",
                body: JSON.stringify({
                    nombre: nombre,
                    observacion: observacion,
                }),
            })
            .then(res => res.json())
            .then((res) => {
                if (res.status === 201) {
                    setNombre("");
                    setObservacion("");
                    setValidated(true);
                } else {
                    alert("Error al crear el equipo");
                }
            });
        } catch (err) {
            console.log(err);
        }
    };
    return (
        <>
        <Container>
            <h2>Agregar Equipo</h2>
                <Form noValidate validated={validated} onSubmit={handleSubmit}>
                    <Form.Group as={Row} className="mb-3" controlId="formBasicEquipo">
                        <Form.Label column sm="3">Nombre Equipo</Form.Label>
                        <Col sm="9">
                            <Form.Control type="text" placeholder="Nombre Equipo" value={nombre}
                                onChange={(e) => setNombre(e.target.value)} />
                            <Form.Control.Feedback type="invalid">Por favor ingrese el nombre del equipo!</Form.Control.Feedback>
                        </Col>
                    </Form.Group>
                    <Form.Group as={Row} className="mb-3" controlId="formBasicDescripcion">
                        <Form.Label column sm="3">Observación</Form.Label>
                        <Col sm="9">
                            <Form.Control type="text" placeholder="Observacion Equipo" value={observacion}
                            onChange={(e) => setObservacion(e.target.value)} />
                        </Col>
                    </Form.Group>
                    <Button variant="primary" type="submit">
                        Inscribir
                    </Button>
                </Form>
            
        </Container>

    </>
    );
}

export default FormEquipo;