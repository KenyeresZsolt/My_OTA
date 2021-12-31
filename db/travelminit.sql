-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Dec 31. 08:52
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 7.4.25

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
-- Tábla szerkezet ehhez a táblához `accm_types`
--

CREATE TABLE `accm_types` (
  `id` int(11) NOT NULL,
  `type_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accm_types`
--

INSERT INTO `accm_types` (`id`, `type_code`, `name`) VALUES
(1, 'HOT', 'Hotel'),
(2, 'PNS', 'Panzió'),
(3, 'GHS', 'Vendégház'),
(4, 'APT', 'Apartman'),
(5, 'VIL', 'Villa'),
(6, 'CHA', 'Kulcsosház'),
(7, 'VAC', 'Nyaraló'),
(8, 'MOT', 'Motel'),
(9, 'HST', 'Hosztel'),
(10, 'CMP', 'Kemping');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `sent_at` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `seen_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `started_by_user_id` int(11) NOT NULL,
  `started_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `conversation_users`
--

CREATE TABLE `conversation_users` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `member_user_id` int(11) NOT NULL
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
  `number_of_attempts` int(11) DEFAULT NULL,
  `sent_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `heroes`
--

CREATE TABLE `heroes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `heroes`
--

INSERT INTO `heroes` (`id`, `name`, `email`, `department_id`) VALUES
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
(17, 'Krivosik Tamás', 'tamas.travelminit@gmail.com', 2),
(18, 'Kenyeres Zsolt', 'k.zsolt@travelminit.com', 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `accm_type` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `disc_price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `packages`
--

INSERT INTO `packages` (`id`, `name`, `location`, `slug`, `accm_type`, `price`, `discount`, `disc_price`, `description`, `image`) VALUES
(1, 'Szeifert Hotel', 'Szováta', 'szeifert-hotel-szovata', 'HOT', 120, 10, 108, 'A szálloda Szovátán, a jól ismert Medve-tó-tól 260 méterre, a Fekete-tó partján helyezkedik el. A Hotel Szeifert szaunával, pezsgőfürdővel, (fizetős szolgáltatás - előzetes bejelentkezéssel a recepción) valamint ingyenes Wi-Fi-hozzáféréssel és vezetékes i', 'public/uploads/hotel-szeifert-szovata-800x416.jpg'),
(2, 'Csatári Panzió', 'Parajd', 'csatari-panzio-parajd', 'PNS', 99, 20, 79, 'Az üdülés idejére vendégeink, igényeik szerint, két- három- és négyágyas, tusolóval és mosdóval ellátott szobákban szállhatnak meg. Ugyanakkor igénybe vehetik éttermünket is, tágas teraszunkat és nyári kertünket is.', 'public/uploads/csatari-panzio-es-etterem-parajd-676x439.jpg'),
(4, 'Septimia Resort & SPA', 'Székelyudvarhely', 'septimia-resort-spa-szekelyudvarhely', 'HOT', 250, 0, 0, 'Septimia - Hotels & SPA Resort ideális hely a kellemes kikapcsolódáshoz, pihenéshez vagy akár üzleti találkozókhoz!\r\n\r\nA szabadidőközpont Erdély keleti részén, a Hargita hegység lábánál, Székelyudvarhelyen található.', 'public/uploads/septimia-resort-hotel-wellness-spa-szekelyudvarhely-676x439.jpg'),
(9, 'Lobogó Panzió', 'Homoródfürdő', 'lobogo-panzio-homorodfurdo', 'PNS', 150, 0, 0, '', 'public/uploads/lobogo-resort-homorodfurdo-676x439.jpg'),
(10, 'Hotel O3zone', 'Tusnádfürdő', 'hotel-o3zone-tusnadfurdo', 'HOT', 250, 10, 225, '', 'public/uploads/hotel-o3zone-tusnadfurdo-676x439.jpg'),
(11, 'Hétvezér Panzió', 'Zeteváralja', 'hetvezer-panzio-zetevaralja', 'PNS', 80, 0, 0, '', 'public/uploads/hetvezer-panzio-zetevaralja-800x600.jpg'),
(12, 'Sugó Panzió', 'Madarasi Hargita', 'sugo-panzio-madarasi-hargita', 'PNS', 90, 0, 0, 'A sípálya tetején található.', 'public/uploads/sugo-panzio-ivo-676x439.jpg'),
(13, 'Enikő Kulcsosház', 'Güdüctelep', 'eniko-kulcsoshaz-guductelep', 'CHA', 50, 0, 0, '', 'public/uploads/eniko-kulcsoshaz-guductelep-676x439.jpg'),
(14, 'Páva Panzió & Wellness', 'Székelyudvarhely', 'pava-panzio-wellness-szekelyudvarhely', 'PNS', 80, 0, 0, '', 'public/uploads/pava-panzio-wellness-szekelyudvarhely-676x439.jpg'),
(15, 'Tip-Top Panzió', 'Kalotaszentkirály', 'tip-top-panzio-kalotaszentkiraly', 'PNS', 60, 0, 0, '', 'public/uploads/tip-top-panzio-kalotaszentkiraly-676x439.jpg'),
(16, 'Szentkirály Panzió', 'Kalotaszentkirály', 'szentkiraly-panzio-kalotaszentkiraly', 'PNS', 55, 0, 0, '', 'public/uploads/szentkiraly-panzio-kalotaszentkiraly-676x439.jpg'),
(22, 'Rossmarkt Haus', 'Brassó', 'rossmarkt-haus-brasso', 'HOT', 300, 25, 225, 'Megfelelő választás azoknak a látogatóknak, akik történelemmel teli helyet keresnek. Az egyik legrégebbi épület Brassóban (1493), a 2019-es teljes felújítás után a Rossmarkt a 21. századi kényelmet és egyedülálló élményt nyújt a 15. század történelmében. ', 'public/uploads/rossmarkt-haus-brasso-676x439.jpg'),
(23, 'Lilla Apartmanok', 'Székelyudvarhely', 'lilla-apartmanok-szekelyudvarhely', 'APT', 200, 10, 180, 'Apartmanjaink ideálisak családoknak, baráti társaságoknak, hiszen az 52 négyzetméteres lakásban kényelmesen elfér 4-5 személy. Két szobával rendelkeznek, a nagyobb szobában egy franciaágy és egy különágy, a kisebb szobában pedig két külön ágy található.', 'public/uploads/lilla-apartmanok-szekelyudvarhely-676x439.jpg'),
(24, 'Piricske Pihenőház', 'Piricske', 'piricske-pihenohaz-piricske', 'CHA', 70, 0, 0, 'A Piricske Pihenőház Hargita megyében található, 15 percnyi autóútra Csíkszeredától és 45 percnyi autóútra Székelyudvarhelytől. A Hargitai havasok fenyveseivel körbevett 150 nm-es erdei faház 2000-ben épült, majd 2016-ban egy teljes felújításon esett át, ', 'public/uploads/piricske-pihenohaz-piricske-50-800x535.jpg'),
(25, 'Csángó-Fatányéros Panziók', 'Hidegség', 'csango-fatanyeros-panziok-hidegseg', 'PNS', 100, 0, 0, 'A panzió az erdélyi Csíki-havasokban, Hargita megyében, Csíkszeredától (rom. Miercurea Ciuc) ÉK irányban 40 km-re fekvő Gyímesközéplok (rom. Lunca de Jos) községhez tartozó Hidegség (rom. Valea Rece) helységben található', 'public/uploads/csango-fatanyeros-panziok-hidegseg-676x439.jpg'),
(26, 'Anda Panzió', 'Gyergyószentmiklós', 'anda-panzio-gyergyoszentmiklos', 'PNS', 100, 30, 70, 'Gyönyörű környezetben patak partján helyezkedik el a panzió.Nagyon csendes környezetben vagyunk a hegyek között ,a tengerszint fölött 900 méterre,közvetlenen a fő közlekedésű út mellett.', 'public/uploads/anda-panzio-gyergyoszentmiklos-676x439.jpg'),
(27, 'Dr. Demeter Béla Vendégház', 'Torockó', 'dr-demeter-bela-vendeghaz-torocko', 'GHS', 150, 0, 0, 'Felejthetetlen pihenes a Szekelyko labanal! Nagy szeretettel varjuk!', 'public/uploads/dr-demeter-bela-vendeghaz-torocko-676x439.jpg'),
(28, 'Dulo Annamária Vendégház', 'Torockó', 'dulo-annamaria-vendeghaz-torocko', 'GHS', 140, 0, 0, 'Töltsön egy pár napot a rusztikusan kialakított vendégházunkban, pihenjen a százéves diófa alatt csodálva a hegyeket, kóstolja meg a hagyományos torockói ízeket, saját készítésű pálinkát, lekvárokat, zakuszkát.', 'public/uploads/dulo-annamaria-vendeghaz-torocko-676x439.jpg');

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
  `total_price` int(11) NOT NULL,
  `reserved_package_id` int(11) NOT NULL
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
  `is_admin` tinyint(1) NOT NULL,
  `registered` int(11) NOT NULL,
  `last_modified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `accm_types`
--
ALTER TABLE `accm_types`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT a táblához `accm_types`
--
ALTER TABLE `accm_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
