-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Dec 27. 17:09
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `travelminit`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `conversationId` int(11) NOT NULL,
  `fromUserId` int(11) NOT NULL,
  `sentAt` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `seenAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `started_by_userID` int(11) NOT NULL,
  `startedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `conversation_users`
--

CREATE TABLE `conversation_users` (
  `id` int(11) NOT NULL,
  `conversationID` int(11) NOT NULL,
  `member_userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'management'),
(2, 'CS'),
(3, 'mentor'),
(4, 'marketing'),
(5, 'development'),
(6, 'HR'),
(7, 'finance'),
(9, 'TIC');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `email_messages`
--

CREATE TABLE `email_messages` (
  `id` int(11) NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('notSent','sending','sent','') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numberOfAttempts` int(11) DEFAULT NULL,
  `sentAt` int(11) DEFAULT NULL,
  `createdAt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `heroes`
--

CREATE TABLE `heroes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `departmentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `heroes`
--

INSERT INTO `heroes` (`id`, `name`, `email`, `departmentId`) VALUES
(1, 'Kenyeres Zsolt', 'k.zsolt@travelminit.com', 4),
(5, 'Simon Linka', 'linka@travelminit.com', 2),
(6, 'Dobri András', 'andris@travelminit.com', 5),
(7, 'Ambrus Timi', 'timi@travelminit.com', 1),
(8, 'Szilveszter Norbi', 'sz.norbert@travelminit.com', 7),
(9, 'Szilveszter Rita', 'rita@travelminit.com', 4),
(10, 'Korodi Berni', 'berni@travelminit.com', 6),
(11, 'Malutan Réka', 'reka@travelminit.com', 9),
(12, 'Rigó Ferenc', 'ferenc@travelmint.com', 1),
(13, 'Buzogány László', 'laci@travelminit.com', 5),
(14, 'Faluvégi Ferenc', 'feco@travelminit.com', 5),
(15, 'Domokos Rudolf', 'rudi@travelminit.com', 2),
(16, 'Szilágyi Pami', 'pamela@travelminit.com', 3),
(17, 'Krivosik Tamás', 'tamas.travelminit@gmail.com', 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `disc_price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `packages`
--

INSERT INTO `packages` (`id`, `name`, `location`, `slug`, `price`, `discount`, `disc_price`, `description`, `image`) VALUES
(1, 'Szeifert Hotel', 'Szováta', 'szeifert-hotel-szovata', 120, 10, 108, 'A szálloda Szovátán, a jól ismert Medve-tó-tól 260 méterre, a Fekete-tó partján helyezkedik el. A Hotel Szeifert szaunával, pezsgőfürdővel, (fizetős szolgáltatás - előzetes bejelentkezéssel a recepción) valamint ingyenes Wi-Fi-hozzáféréssel és vezetékes i', 'public/uploads/hotel-szeifert-szovata-800x416.jpg'),
(2, 'Csatári Panzió', 'Parajd', 'csatari-panzio-parajd', 99, 20, 79, 'Az üdülés idejére vendégeink, igényeik szerint, két- három- és négyágyas, tusolóval és mosdóval ellátott szobákban szállhatnak meg. Ugyanakkor igénybe vehetik éttermünket is, tágas teraszunkat és nyári kertünket is.', 'public/uploads/csatari-panzio-es-etterem-parajd-676x439.jpg'),
(4, 'Septimia Resort & SPA', 'Székelyudvarhely', 'septimia-resort--spa-szekelyudvarhely', 250, 0, 0, 'Septimia - Hotels & SPA Resort ideális hely a kellemes kikapcsolódáshoz, pihenéshez vagy akár üzleti találkozókhoz!\r\n\r\nA szabadidőközpont Erdély keleti részén, a Hargita hegység lábánál, Székelyudvarhelyen található.', 'public/uploads/septimia-resort-hotel-wellness-spa-szekelyudvarhely-676x439.jpg'),
(9, 'Lobogó Panzió', 'Homoródfürdő', 'lobogo-panzio-homorodfurdo', 150, 0, 0, '', 'public/uploads/lobogo-resort-homorodfurdo-676x439.jpg'),
(10, 'Hotel O3zone', 'Tusnádfürdő', 'hotel-o3zone-tusnadfurdo', 250, 10, 225, '', 'public/uploads/hotel-o3zone-tusnadfurdo-676x439.jpg'),
(11, 'Hétvezér Panzió', 'Zeteváralja', 'hetvezer-panzio-zetevaralja', 80, 0, 0, '', 'public/uploads/hetvezer-panzio-zetevaralja-800x600.jpg'),
(12, 'Sugó Panzió', 'Madarasi Hargita', 'sugo-panzio-madarasi-hargita', 90, 0, 0, 'A sípálya tetején található.', 'public/uploads/sugo-panzio-ivo-676x439.jpg'),
(13, 'Enikő Kulcsosház', 'Güdüctelep', 'eniko-kulcsoshaz-guductelep', 50, 0, 0, '', 'public/uploads/eniko-kulcsoshaz-guductelep-676x439.jpg'),
(14, 'Páva Panzió & Wellness', 'Székelyudvarhely', 'pava-panzio--wellness-szekelyudvarhely', 80, 0, 0, '', 'public/uploads/pava-panzio-wellness-szekelyudvarhely-676x439.jpg'),
(15, 'Tip-Top Panzió', 'Kalotaszentkirály', 'tip-top-panzio-kalotaszentkiraly', 60, 0, 0, '', 'public/uploads/tip-top-panzio-kalotaszentkiraly-676x439.jpg'),
(16, 'Szentkirály Panzió', 'Kalotaszentkirály', 'szentkiraly-panzio-kalotaszentkiraly', 55, 0, 0, '', 'public/uploads/szentkiraly-panzio-kalotaszentkiraly-676x439.jpg'),
(22, 'Rossmarkt Haus', 'Brassó', 'rossmarkt-haus-brasso', 300, 25, 225, 'Megfelelő választás azoknak a látogatóknak, akik történelemmel teli helyet keresnek. Az egyik legrégebbi épület Brassóban (1493), a 2019-es teljes felújítás után a Rossmarkt a 21. századi kényelmet és egyedülálló élményt nyújt a 15. század történelmében. ', 'public/uploads/rossmarkt-haus-brasso-676x439.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `reserved` int(11) NOT NULL,
  `guests` int(11) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `nights` int(11) NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `reservedPackageId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `lastModified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `conversation_users`
--
ALTER TABLE `conversation_users`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `email_messages`
--
ALTER TABLE `email_messages`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `heroes`
--
ALTER TABLE `heroes`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `conversation_users`
--
ALTER TABLE `conversation_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `email_messages`
--
ALTER TABLE `email_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `heroes`
--
ALTER TABLE `heroes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT a táblához `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT a táblához `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
