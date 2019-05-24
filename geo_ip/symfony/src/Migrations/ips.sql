-- таблица логов
DROP SEQUENCE IF EXISTS ips_id_seq CASCADE;
CREATE SEQUENCE ips_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
DROP TABLE IF EXISTS ips CASCADE;
CREATE TABLE ips (
    id INTEGER DEFAULT nextval('ips_id_seq'::regclass) NOT NULL PRIMARY KEY,
    -- ip address
    ip cidr NOT NULL UNIQUE,
    -- 2ух символьный идентификатор страны по стандарту ISO 3166-1
    country_code VARCHAR(2) DEFAULT NULL,
    -- название страны на английском языке
    country VARCHAR(255) DEFAULT NULL,
    -- название страны на русском языке
    country_rus VARCHAR(255) DEFAULT NULL,
    -- название региона на английском языке
    region VARCHAR(255) DEFAULT NULL,
    -- название региона на русском языке
    region_rus VARCHAR(255) DEFAULT NULL,
    -- название населенного пункта (города) на английском языке
    city VARCHAR(255) DEFAULT NULL,
    -- название населенного пункта (города) на русском языке
    city_rus VARCHAR(255) DEFAULT NULL,
    -- географическая широта
    latitude FLOAT DEFAULT NULL,
    -- географическая долгота
    longitude FLOAT DEFAULT NULL,
    -- почтовый индекс
    zip_code INTEGER DEFAULT  NULL,
    --  часовой пояс
    time_zone VARCHAR(20)
);

-- indexes
CREATE INDEX ips_ip_idx ON ips(ip);
CREATE INDEX ips_country_code_idx ON ips(country_code);
CREATE INDEX ips_ip_country_code_idx ON ips(ip, country_code);
