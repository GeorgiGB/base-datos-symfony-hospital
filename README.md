# base-datos-symfony-hospital

Una base de datos de un hospital privado es un sistema que permite gestionar y organizar la información de los pacientes, 
médicos y enfermedades registradas en el hospital. En la base de datos se puede guardar información detallada sobre cada paciente, 
como su nombre, edad, historial médico y las enfermedades que padece. 

También se puede registrar información sobre los médicos, como su nombre, especialidad y asignación a un paciente específico. 
Además, la base de datos puede incluir información sobre las enfermedades registradas en el hospital y su tratamiento.

En esta base de datos, cada paciente tiene asignado un solo médico para su atención. 
Por lo que se le permite hacer el seguimiento de cada paciente en particular y su historial médico. 
Si un paciente padece una enfermedad que ya está registrada, se puede acceder a la información previa para realizar un tratamiento efectivo.
Si el paciente tiene una enfermedad nueva, se puede registrar en la base de datos a través del médico asignado.

graph TD;
  Pacientes -->|tiene| HistorialMédico;
  Médicos -->|atienden| Pacientes;
  Enfermedades -->|se registran en| HistorialMédico;
