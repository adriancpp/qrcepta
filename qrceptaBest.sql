
CREATE TABLE `prescription` (
  `id` int NOT NULL,
  `author_id` int NOT NULL,
  `recommendation` varchar(255) NOT NULL,
  `medicines` varchar(255) NOT NULL,
  `security_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `patient_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
  `id` int NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `role` varchar(50) NOT NULL,
  `pesel` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_id` (`patient_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `prescription`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `prescription`
  ADD CONSTRAINT `fk_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `user` (`id`);


===================
CREATE TABLE prescription (
  id serial PRIMARY KEY NOT NULL,
  author_id int NOT NULL,
  recommendation varchar(255) NOT NULL,
  medicines varchar(255) NOT NULL,
  security_code varchar(255) NOT NULL,
  created_at date NOT NULL,
  updated_at date NOT NULL,
  patient_id int NOT NULL
);


CREATE TABLE "user" (
  id   serial PRIMARY KEY NOT NULL,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  updated_at date NOT NULL,
  role varchar(50) NOT NULL,
  pesel varchar(50) NOT NULL,
  created_at date NOT NULL
);


ALTER TABLE prescription
ADD COLUMN status varchar(30) NOT NULL
;

ALTER TABLE prescription
ADD COLUMN qr_code_img bytea NOT NULL
;

 qr_code_img     bytea        NOT NULL,

