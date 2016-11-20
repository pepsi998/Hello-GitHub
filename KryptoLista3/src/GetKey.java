import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.util.Scanner;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import javax.xml.bind.DatatypeConverter;

public class GetKey {

	private static Cipher cipher;
	private static IvParameterSpec iv;
	private static SecretKeySpec secretKey;
	
	public static String  getKey(File keystore, int keyNumber, String ivec, String secret) throws NoSuchAlgorithmException, NoSuchPaddingException, InvalidKeyException, InvalidAlgorithmParameterException, IOException, IllegalBlockSizeException, BadPaddingException	{
		
			byte [] b = DatatypeConverter.parseHexBinary(ivec);
			cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
			iv = new IvParameterSpec(b);
			secretKey = new SecretKeySpec(secret.getBytes("UTF-8"), "AES");
			cipher.init(Cipher.DECRYPT_MODE, secretKey, iv);
			FileInputStream inputStream = new FileInputStream(keystore);
	        byte[] inputBytes = new byte[(int) keystore.length()];
	        inputStream.read(inputBytes);
	        byte[] passByte = cipher.doFinal(inputBytes);
	        String password = new String(passByte);
	        inputStream.close();
		
	        String[] lines = password.split(System.getProperty("line.separator"));
			
			return lines[2*keyNumber]+" "+lines[2*keyNumber+1];
	}
}
