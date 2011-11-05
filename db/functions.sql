
DELIMITER $$

DROP FUNCTION IF EXISTS count_votes$$
CREATE FUNCTION count_votes (qid INT) RETURNS INT
BEGIN
DECLARE total INT;
SELECT SUM(votes.vote) INTO total FROM votes WHERE votes.quote_id = qid;
RETURN total;
END $$

DROP PROCEDURE IF EXISTS fetch_quote $$
CREATE PROCEDURE fetch_quote (IN qid INT)
BEGIN
UPDATE quotes SET rating=count_votes(qid) WHERE id=qid;
SELECT * FROM quotes WHERE id=qid;
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

DROP FUNCTION IF EXISTS ip_p $$
CREATE FUNCTION ip_p(qid INT, ip VARCHAR(15)) RETURNS INT
BEGIN
	DECLARE c INT;
	SELECT COUNT(ip_addr) INTO c FROM votes WHERE quote_id = qid AND ip_addr = ip;
	RETURN c;
END $$

DROP PROCEDURE IF EXISTS add_quote $$
CREATE PROCEDURE add_quote(IN qt TEXT)
BEGIN
	INSERT INTO quotes SET quote_text=qt, created=NOW();
END $$

DROP PROCEDURE IF EXISTS add_vote $$
CREATE PROCEDURE add_vote(qid INT, ip VARCHAR(15), v INT)
BEGIN
	IF ip_p(qid,ip) THEN
	   BEGIN
	   UPDATE votes SET vote=v WHERE quote_id=qid AND ip_addr = ip;
	   CALL update_rating(qid);
	   SELECT "Updated";
	   END ;
	ELSE
		BEGIN
		INSERT INTO votes SET quote_id=qid, ip_addr = ip, vote=v, created=NOW();
		CALL update_rating(qid);
		SELECT "Added";
		END ;
	END IF;
END $$


DELIMITER ;


