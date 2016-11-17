
import java.nio.charset.StandardCharsets;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.util.Base64;
import java.util.Base64.Decoder;

import javax.crypto.Cipher;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import javax.xml.bind.DatatypeConverter;

public class Decrypt
{
	
	byte[] iv;
	String b64;
	String keysuff;
	Decoder dec;
	byte[] decoded;
	byte[] result;
	IvParameterSpec ivs;
	Cipher cipher;

	Decrypt(String ivec, String toDecrypt, String suff)
	{
		iv = DatatypeConverter.parseHexBinary(ivec);
		b64 = toDecrypt;
		keysuff = suff;
		dec = Base64.getDecoder();
		decoded = dec.decode(b64.getBytes());
		ivs = new IvParameterSpec(iv);
	}

	public void decode(String key) throws NoSuchAlgorithmException, NoSuchPaddingException, InvalidKeyException,
			InvalidAlgorithmParameterException
	{

		byte[] kv = DatatypeConverter.parseHexBinary(key);

		SecretKeySpec sks = new SecretKeySpec(kv, "AES");

		cipher.init(Cipher.DECRYPT_MODE, sks, ivs);

		result = cipher.update(decoded);
		if (isCorrect(result))
		{
			String str = new String(result, StandardCharsets.UTF_8);
			System.out.println(str);
			System.out.println("key: " + key);
		
		}
		
		
	}
	private boolean isCorrect(byte[] end)
	{

		for (int i = 0; i < end.length; ++i)
		{

			if (end[i] < 0)
				return false;
		}
		return true;
	}

}