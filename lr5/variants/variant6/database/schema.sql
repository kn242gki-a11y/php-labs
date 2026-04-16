
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20) DEFAULT '',
    city VARCHAR(50) DEFAULT '',
    gender VARCHAR(10) DEFAULT '',
    about TEXT DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS animals (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(100) DEFAULT '',
    age INTEGER DEFAULT 0,
    owner VARCHAR(150) NOT NULL,
    microchip VARCHAR(50) DEFAULT '',
    weight DECIMAL(5,2) DEFAULT 0,
    health_status VARCHAR(50) DEFAULT 'здорова',
    last_visit DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS health_records (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    animal_id INTEGER NOT NULL,
    visit_date DATE NOT NULL,
    diagnosis TEXT DEFAULT '',
    treatment TEXT DEFAULT '',
    vet_notes TEXT DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (animal_id) REFERENCES animals(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vaccinations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    animal_id INTEGER NOT NULL,
    vaccine_name VARCHAR(100) NOT NULL,
    vaccination_date DATE NOT NULL,
    next_due_date DATE,
    vet_name VARCHAR(100),
    notes TEXT DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (animal_id) REFERENCES animals(id) ON DELETE CASCADE
);

INSERT INTO animals (name, species, breed, age, owner, health_status) VALUES
    ('Барон', 'Собака', 'Лабрадор', 3, 'Іван Петренко', 'здорова'),
    ('Мурка', 'Кіт', 'Сіамська', 2, 'Марія Іваненко', 'здорова'),
    ('Кеша', 'Птах', 'Папуга', 1, 'Олексій Сидоров', 'здорова'),
    ('Шарік', 'Собака', 'Бульдог', 5, 'Анна Коваленко', 'потребує опіки'),
    ('Рижик', 'Кіт', 'Персидська', 4, 'Дмитро Мельник', 'здорова');

CREATE TABLE IF NOT EXISTS emergency_requests (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    owner_name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    animal_name VARCHAR(100) NOT NULL,
    problem TEXT NOT NULL,
    urgency VARCHAR(20) NOT NULL,
    status VARCHAR(20) DEFAULT 'new',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS home_visits (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    owner_name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    animal_name VARCHAR(100) NOT NULL,
    problem TEXT DEFAULT '',
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS volunteers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    position VARCHAR(50) NOT NULL,
    experience TEXT DEFAULT '',
    availability VARCHAR(100) DEFAULT 'Вихідні',
    status VARCHAR(20) DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO volunteers (name, email, phone, position, experience, availability, status) VALUES
    ('Марія Коваль', 'maria@email.com', '+380 97 123 4567', 'Опікун тварин', 'Досвід 3 роки', 'Вихідні', 'approved'),
    ('Іван Петренко', 'ivan@email.com', '+380 99 234 5678', 'Організатор подій', 'Досвід 5 років', 'Будні', 'approved'),
    ('Олена Іванівна', 'olena@email.com', '+380 95 345 6789', 'Соціальний працівник', 'Досвід 2 роки', 'Гнучкий графік', 'approved');
