-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2023 a las 12:14:55
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `svelt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

CREATE TABLE `invoices` (
  `idInvoices` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `SuperUser_idSuperUser` varchar(10) NOT NULL,
  `User_user_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parkingplace`
--

CREATE TABLE `parkingplace` (
  `idparkingPlace` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `isTemporally` varchar(1) NOT NULL,
  `state` varchar(1) NOT NULL,
  `SuperUser_idSuperUser` varchar(10) NOT NULL,
  `latitud` decimal(9,6) NOT NULL,
  `longitud` decimal(9,6) NOT NULL,
  `Referencia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `parkingplace`
--

INSERT INTO `parkingplace` (`idparkingPlace`, `ciudad`, `calle`, `isTemporally`, `state`, `SuperUser_idSuperUser`, `latitud`, `longitud`, `Referencia`) VALUES
(2, 'El Puerto de Santa María', 'Av. Santa María del Mar 17', '0', '1', '5', '36.573262', '-6.221772', 'Frente a \"Las terrazas\"'),
(3, 'El Puerto de Santa María', 'Centro comercial Bahia Mar', '0', '1', '5', '36.593085', '-6.220912', 'Frente al \"Tedi Shop\"'),
(4, 'El Puerto de Santa María', 'Plaza del Polvorista', '0', '1', '5', '36.594674', '-6.227450', 'Frente a \"Correos\"'),
(5, 'El Puerto de Santa María', 'Plaza de toros', '0', '1', '5', '36.597532', '-6.232650', 'Esquina de \"Asesoría SLP\"'),
(6, 'El Puerto de Santa María', 'Playa de la Calita', '0', '1', '5', '36.583596', '-6.267972', 'Junto a las escaleras de bajada'),
(12, 'Cádiz', 'Calle García Quijano 2 11012', '1', '1', '5', '36.515663', '-6.277270', 'Frente a CrossFit Erytheia'),
(13, 'El Puerto de Santa María', 'Calle Mendoza 3 11500', '1', '1', '5', '36.608229', '-6.228873', 'Esquina covirant'),
(15, 'El Puerto de Santa María', 'Plaza de las Galeras Reales S/N 11500', '1', '1', '5', '36.597564', '-6.224270', 'Zona de taxistas'),
(16, 'El Puerto de Santa María', 'Calle de los Gallardo S/N 11500', '1', '1', '5', '36.597723', '-6.238180', 'Cerca del Hospital'),
(17, 'Cádiz', 'Paseo Almirante Pascual Pery Junquera 25 11071', '1', '1', '5', '36.539951', '-6.289871', 'Frente al Momart'),
(18, 'Cádiz', 'Plaza de Falla S/N 11003', '1', '1', '5', '36.534020', '-6.301899', 'Al Lado del falla'),
(20, 'El Puerto de Santa María', 'Avenida Rafael Alberti 9 11500', '1', '1', '5', '36.594127', '-6.242189', 'Frente al IES Mar de Cádiz'),
(21, 'Cádiz', 'Avenida Bahía Blanca 6 11007', '1', '1', '26', '36.525930', '-6.288037', 'Frente a Astilleros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `superuser`
--

CREATE TABLE `superuser` (
  `idSuperUser` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `superuser`
--

INSERT INTO `superuser` (`idSuperUser`) VALUES
('16'),
('23'),
('26'),
('4kBu\".D$:2'),
('5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `user_code` int(11) NOT NULL,
  `balance` float NOT NULL,
  `name` varchar(45) NOT NULL,
  `lastName` varchar(80) NOT NULL,
  `Vehicle_registration` varchar(8) DEFAULT NULL,
  `SuperUser_idSuperUser` varchar(10) DEFAULT NULL,
  `dni` varchar(9) NOT NULL,
  `salt` varchar(45) NOT NULL,
  `activation_code` varchar(6) NOT NULL,
  `isActive` bit(1) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `usingParking` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_code`, `balance`, `name`, `lastName`, `Vehicle_registration`, `SuperUser_idSuperUser`, `dni`, `salt`, `activation_code`, `isActive`, `email`, `password`, `usingParking`) VALUES
(5, 99999, 'Svelt', 'Inc', '0020DTD', '5', '54335580N', 'ln.qq*rm0dauhrz6', '000000', b'1', 'svelt@svelt.com', 'e10adc3949ba59abbe56e057f20f883e', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_tokens`
--

CREATE TABLE `user_tokens` (
  `tokenId` int(11) NOT NULL,
  `user_code` int(11) NOT NULL,
  `isActive` int(11) NOT NULL,
  `Token` varchar(45) NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user_tokens`
--

INSERT INTO `user_tokens` (`tokenId`, `user_code`, `isActive`, `Token`, `Fecha`) VALUES
(68, 5, 1, '3090ed9c9a238f96e96dac95cfef8635', '2023-06-15 18:05:00'),
(69, 5, 1, '68a91d00fff586b42de7cc3e395ca2ff', '2023-06-15 18:18:00'),
(70, 5, 1, 'efa5f613b7601d83bce450a3e16f7f6e', '2023-06-15 18:20:00'),
(71, 5, 1, '5dd41d271e1ec63611d953bee66aa874', '2023-06-15 18:23:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehicle`
--

CREATE TABLE `vehicle` (
  `registration` varchar(8) NOT NULL,
  `color` varchar(10) DEFAULT NULL,
  `model` varchar(45) DEFAULT NULL,
  `ceroconsumo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vehicle`
--

INSERT INTO `vehicle` (`registration`, `color`, `model`, `ceroconsumo`) VALUES
('0000DTD', 'gray', 'Cupra', '1'),
('0001DTD', 'whiteC2A', 'DTD2', '1'),
('0002DTD', 'Green', 'WD', '1'),
('0007DTD', 'Gray', 'DTD2', '1'),
('0009DTD', 'black', 'DTD2', '0'),
('0012DTD', 'aqua', 'aston', '1'),
('0013DTD', 'Blue', 'Tesla', '0'),
('0020DTD', 'Blue', 'Tesla', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`idInvoices`),
  ADD KEY `fk_Invoices_SuperUser1_idx` (`SuperUser_idSuperUser`),
  ADD KEY `fk_Invoices_User1_idx` (`User_user_code`);

--
-- Indices de la tabla `parkingplace`
--
ALTER TABLE `parkingplace`
  ADD PRIMARY KEY (`idparkingPlace`),
  ADD KEY `fk_parkingPlace_SuperUser1_idx` (`SuperUser_idSuperUser`);

--
-- Indices de la tabla `superuser`
--
ALTER TABLE `superuser`
  ADD PRIMARY KEY (`idSuperUser`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_code`),
  ADD KEY `fk_User_Vehicle_idx` (`Vehicle_registration`),
  ADD KEY `fk_User_SuperUser1_idx` (`SuperUser_idSuperUser`),
  ADD KEY `fk_User_ParkingPlace` (`usingParking`);

--
-- Indices de la tabla `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`tokenId`),
  ADD KEY `user_tokens_ibfk_1` (`user_code`);

--
-- Indices de la tabla `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`registration`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `invoices`
--
ALTER TABLE `invoices`
  MODIFY `idInvoices` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `parkingplace`
--
ALTER TABLE `parkingplace`
  MODIFY `idparkingPlace` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `tokenId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_Invoices_SuperUser1` FOREIGN KEY (`SuperUser_idSuperUser`) REFERENCES `superuser` (`idSuperUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Invoices_User1` FOREIGN KEY (`User_user_code`) REFERENCES `user` (`user_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `parkingplace`
--
ALTER TABLE `parkingplace`
  ADD CONSTRAINT `fk_parkingPlace_SuperUser1` FOREIGN KEY (`SuperUser_idSuperUser`) REFERENCES `superuser` (`idSuperUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_ParkingPlace` FOREIGN KEY (`usingParking`) REFERENCES `parkingplace` (`idparkingPlace`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_SuperUser1` FOREIGN KEY (`SuperUser_idSuperUser`) REFERENCES `superuser` (`idSuperUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_Vehicle` FOREIGN KEY (`Vehicle_registration`) REFERENCES `vehicle` (`registration`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_code`) REFERENCES `user` (`user_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
