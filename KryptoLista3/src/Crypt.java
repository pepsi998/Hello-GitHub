import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.util.Base64;
import java.util.Base64.Decoder;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import javax.xml.bind.DatatypeConverter;

public class Crypt {

	private static String secret = "ToJestKluczyk1AA";
	private static String ivec = "0086e4d2de3242e1c32ecd96dd9a1429";
	private static Cipher cipher;
	private static IvParameterSpec iv;
	private static SecretKeySpec secretKey;
	/*
	 * Koduje haslo przy pierwszym logowaniu 
	 * @param password haslo podane przy logowaniu
	 * @param output zakodowany plik z haslem 
	 */
	public static void EncodePassword(String password, File output ) throws NoSuchAlgorithmException, NoSuchPaddingException, InvalidKeyException, IllegalBlockSizeException, BadPaddingException, InvalidAlgorithmParameterException, IOException	{
		
		byte [] b = DatatypeConverter.parseHexBinary(ivec);
		cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
		iv = new IvParameterSpec(b);
		secretKey = new SecretKeySpec(secret.getBytes("UTF-8"), "AES");
		cipher.init(Cipher.ENCRYPT_MODE, secretKey, iv);
         
        byte[] outputBytes = cipher.doFinal(password.getBytes());
         
        FileOutputStream outputStream = new FileOutputStream(output);
        outputStream.write(outputBytes);
        outputStream.close();
        
	}
	/**
	 * Koduje plik z kluczami na zakodowany keystore
	 */
	
	public static void EncodeKeyStore(File inputFile, String outPath) throws NoSuchAlgorithmException, NoSuchPaddingException, InvalidKeyException, InvalidAlgorithmParameterException, IOException, IllegalBlockSizeException, BadPaddingException	{
		byte [] b = DatatypeConverter.parseHexBinary(ivec);
		cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
		iv = new IvParameterSpec(b);
		secretKey = new SecretKeySpec(secret.getBytes("UTF-8"), "AES");
		cipher.init(Cipher.ENCRYPT_MODE, secretKey, iv);
         
		FileInputStream inputStream = new FileInputStream(inputFile);
        byte[] inputBytes = new byte[(int) inputFile.length()];
        inputStream.read(inputBytes);
        
        byte[] outputBytes = cipher.doFinal(inputBytes);
        
        File outputFile = new File(outPath);
        FileOutputStream outputStream = new FileOutputStream(outputFile);
        outputStream.write(outputBytes);
         
        inputStream.close();
        outputStream.close();
        
        inputFile.delete();
	}
	/*
	 * Sprawdza czy podane haslo jest tym zakodowanym
	 */
	public static boolean DecodePassword(String passwordToCheck) throws NoSuchAlgorithmException, NoSuchPaddingException, InvalidKeyException, IllegalBlockSizeException, BadPaddingException, InvalidAlgorithmParameterException, IOException	{
		
		byte [] b = DatatypeConverter.parseHexBinary(ivec);
		cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
		iv = new IvParameterSpec(b);
		secretKey = new SecretKeySpec(secret.getBytes("UTF-8"), "AES");
		cipher.init(Cipher.DECRYPT_MODE, secretKey, iv);
		File file = new File("config");
		FileInputStream inputStream = new FileInputStream(file);
        byte[] inputBytes = new byte[(int) file.length()];
        inputStream.read(inputBytes);
                  
        String savedPassword = new String(cipher.doFinal(inputBytes));
        
        inputStream.close();
        return passwordToCheck.equals(savedPassword);
		
	}
	
	public static void doCrypt(File inputFile, File outputFile, int keyNumber, int cryptMode, String scheme, String type) throws FileDoesntExistException, NoSuchAlgorithmException, NoSuchPaddingException, IllegalBlockSizeException, BadPaddingException, IOException, InvalidKeyException, InvalidAlgorithmParameterException	{
		
		if(!inputFile.exists()) throw new FileDoesntExistException("Folder doesnt exist");
			
		String [] keyAndIv = GetKey.getKey(new File("keystore"), keyNumber, ivec, secret).split(" ");
		cipher = Cipher.getInstance(scheme+"/" + type +"/PKCS5Padding");
		
		byte [] b = DatatypeConverter.parseHexBinary(keyAndIv[1]);
		cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
		iv = new IvParameterSpec(b);
		
		secretKey = new SecretKeySpec(keyAndIv[0].getBytes(), "AES");
		cipher.init(cryptMode, secretKey, iv);
		
		FileInputStream inputStream = new FileInputStream(inputFile);
        byte[] inputBytes = new byte[(int) inputFile.length()];
        inputStream.read(inputBytes);
         
        byte[] outputBytes = cipher.doFinal(inputBytes);
         
        FileOutputStream outputStream = new FileOutputStream(outputFile);
        outputStream.write(outputBytes);
         
        inputStream.close();
        outputStream.close();
        inputFile.delete();
		
	}
	
}
