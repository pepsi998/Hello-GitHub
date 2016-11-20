import static org.junit.Assert.*;

import java.io.File;
import java.io.IOException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;

import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;

import org.junit.Test;

public class Zadanie1Tests {

	@Test
	public void CheckPassword() throws InvalidKeyException, NoSuchAlgorithmException, NoSuchPaddingException, IllegalBlockSizeException, BadPaddingException, InvalidAlgorithmParameterException, IOException {
		Crypt.EncodePassword("mojehaslo", new File("config"));
		assertTrue(Crypt.DecodePassword("mojehaslo"));
	}
	
	@Test
	public void CheckWrongPassword() throws InvalidKeyException, NoSuchAlgorithmException, NoSuchPaddingException, IllegalBlockSizeException, BadPaddingException, InvalidAlgorithmParameterException, IOException	{
		Crypt.EncodePassword("mojehaslo", new File("config"));
		assertFalse(Crypt.DecodePassword("mojezlee"));
	}
	
	

}
