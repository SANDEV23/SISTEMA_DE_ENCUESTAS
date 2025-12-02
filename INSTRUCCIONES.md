# Sistema de Encuestas - Instrucciones de Uso

## Descripción
Sistema completo de gestión de encuestas que permite a empresas crear, gestionar y analizar encuestas de manera profesional.

## Características Implementadas

### 1. Gestión de Empresas
- Registro de empresas clientes
- Visualización de empresas activas
- Asociación de usuarios a empresas

### 2. Gestión de Usuarios
- Registro de usuarios vinculados a empresas
- Autenticación (login/logout)
- Roles de usuario (admin/user)
- Estados activo/inactivo

### 3. Gestión de Encuestas
- Crear encuestas con título y descripción
- Editar encuestas existentes
- Eliminar encuestas
- Ver listado de encuestas por empresa

### 4. Gestión de Preguntas
- Tres tipos de preguntas:
  - **Texto libre**: Respuesta abierta
  - **Selección única**: Una opción (radio buttons)
  - **Selección múltiple**: Varias opciones (checkboxes)
- Agregar múltiples preguntas por encuesta
- Agregar opciones de respuesta dinámicamente
- Eliminar preguntas

### 5. Respuestas a Encuestas
- Formulario público para responder encuestas
- Captura de datos del respondente (nombre y email)
- Validación de respuestas obligatorias
- Página de agradecimiento

### 6. Reportes y Análisis
- Reporte general con estadísticas:
  - Gráficos de barras para opciones múltiples
  - Porcentajes de respuestas
  - Respuestas de texto agrupadas
- Respuestas individuales por participante
- Total de participantes únicos

## Estructura de la Base de Datos

### Tablas Principales:
1. **companies** - Empresas clientes
2. **users** - Usuarios del sistema
3. **surveys** - Encuestas
4. **questions** - Preguntas de las encuestas
5. **options** - Opciones de respuesta para preguntas
6. **answers** - Respuestas de los participantes

## Rutas Principales

### Públicas:
- `/` - Página de inicio
- `/login` - Iniciar sesión
- `/register` - Registrar usuario
- `/companies/register` - Registrar empresa
- `/surveys/{id}/view` - Ver y responder encuesta

### Protegidas (requieren autenticación):
- `/dashboard` - Panel principal
- `/surveys` - Listado de encuestas
- `/surveys/create` - Crear encuesta
- `/surveys/{id}/questions/create` - Agregar preguntas
- `/surveys/{id}/report` - Ver reportes
- `/companies` - Ver empresas

## Flujo de Uso Completo

### 1. Registrar una Empresa
1. Ir a `/companies/register`
2. Llenar el formulario con:
   - Nombre de la empresa
   - Email de contacto
   - Teléfono (opcional)
   - Dirección (opcional)
   - Sitio web (opcional)
3. Enviar formulario

### 2. Registrar un Usuario
1. Ir a `/register`
2. Llenar datos personales:
   - Nombre completo
   - Email
   - Contraseña (mínimo 8 caracteres)
   - Teléfono (opcional)
3. Enviar formulario
4. El sistema redirige al dashboard

### 3. Crear una Encuesta
1. Iniciar sesión
2. Ir a Dashboard o `/surveys`
3. Click en "Crear Nueva Encuesta"
4. Ingresar:
   - Título de la encuesta
   - Descripción (opcional)
5. Click en "Crear y Agregar Preguntas"

### 4. Agregar Preguntas
1. Después de crear la encuesta, se abre la vista de preguntas
2. Para cada pregunta:
   - Escribir el texto de la pregunta
   - Seleccionar el tipo (texto/única/múltiple)
   - Si es única o múltiple, agregar opciones
   - Click en "Agregar Pregunta"
3. Repetir para todas las preguntas
4. Click en "Finalizar Encuesta"

### 5. Compartir la Encuesta
- La URL pública de la encuesta es: `/surveys/{id}/view`
- Compartir este link con los participantes
- No requiere autenticación para responder

### 6. Responder una Encuesta
1. Abrir el link compartido
2. Llenar datos del participante:
   - Nombre
   - Email
3. Responder todas las preguntas
4. Click en "Enviar Respuestas"
5. Se muestra página de agradecimiento

### 7. Ver Reportes
1. Ir a `/surveys`
2. Click en "Reportes" en la encuesta deseada
3. Ver:
   - Resumen general
   - Gráficos por pregunta
   - Porcentajes de respuestas
4. Click en "Ver Respuestas Individuales" para detalle completo

## Comandos Útiles

### Iniciar el Servidor
```bash
php artisan serve
```

### Ejecutar Migraciones
```bash
php artisan migrate
```

### Resetear Base de Datos
```bash
php artisan migrate:fresh
```

### Ver Rutas
```bash
php artisan route:list
```

## Credenciales de Prueba

Para crear usuarios de prueba, usa el registro normal:
- Email: cualquier email válido
- Password: mínimo 8 caracteres

## Tipos de Pregunta

### 1. Texto Libre (type: text)
- Permite respuestas abiertas
- Campo de texto multilínea
- No requiere opciones

### 2. Selección Única (type: select)
- Una sola opción seleccionable
- Radio buttons
- Requiere mínimo 2 opciones

### 3. Selección Múltiple (type: checkbox)
- Varias opciones seleccionables
- Checkboxes
- Requiere mínimo 2 opciones

## Notas Importantes

1. **Seguridad**: Las encuestas públicas no requieren autenticación para responder
2. **Validación**: El sistema valida que las preguntas de selección tengan opciones
3. **Respuestas Múltiples**: Un mismo email puede responder una encuesta solo una vez
4. **Eliminación**: Al eliminar una encuesta, se eliminan todas sus preguntas y respuestas
5. **Empresas**: Cada usuario puede estar asociado a una empresa
6. **Reportes**: Solo usuarios autenticados de la empresa pueden ver reportes

## Mejoras Futuras Sugeridas

- Exportar reportes a PDF/Excel
- Envío de encuestas por email
- Plantillas de encuestas predefinidas
- Lógica condicional en preguntas
- Análisis de sentimientos en respuestas de texto
- Dashboard con métricas generales
- Notificaciones de nuevas respuestas
- Configuración de fecha límite para encuestas
- Encuestas anónimas vs identificadas
- Temas personalizables para encuestas

## Soporte Técnico

Para problemas o dudas:
1. Verificar que las migraciones estén ejecutadas
2. Verificar configuración de base de datos en `.env`
3. Limpiar caché: `php artisan cache:clear`
4. Revisar logs: `storage/logs/laravel.log`

---

Desarrollado con Laravel 11 siguiendo el flujo especificado en `flujo trabajo.md`
