
DELIMITER $$

DROP FUNCTION IF EXISTS count_votes$$
CREATE FUNCTION count_votes (qid INT) RETURNS INT
BEGIN
DECLARE total INT;
SELECT SUM(votes.vote) INTO total FROM votes WHERE votes.quote_id = qid;
RETURN total;
END $$

DROP PROCEDURE IF EXISTS update_rating$$
CREATE PROCEDURE update_rating(IN qid INT)
BEGIN
UPDATE quotes SET rating=count_votes(qid) WHERE id=qid;
END $$

-- DROP PROCEDURE IF EXISTS retrieve_quotes_partial $$
-- CREATE PROCEDURE retrieve_quotes_partial (IN ofst INT, IN lmt INT)
-- BEGIN
-- 	SELECT quote_text, rating FROM quotes LIMIT ofst, lmt;
-- END $$

DROP PROCEDURE IF EXISTS count_quotes $$
CREATE PROCEDURE count_quotes ()
BEGIN
	SELECT COUNT(quotes.id) FROM quotes;
END $$

DROP PROCEDURE IF EXISTS check_ip $$
CREATE PROCEDURE check_ip (IN qid INT, IN ip VARCHAR(15))
BEGIN
	SELECT COUNT(ip_addr) FROM votes WHERE quote_id = qid AND ip_addr = ip;
END $$	

DELIMITER ;


